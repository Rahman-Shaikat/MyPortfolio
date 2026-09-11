import * as THREE from 'three';

export function initResearchVideo(video) {
    const host = video.closest('.research-video');
    const motion = matchMedia('(prefers-reduced-motion: reduce)');
    const pointerDevice = matchMedia('(hover: hover) and (pointer: fine)');
    if (!host || motion.matches || !pointerDevice.matches) return;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    } catch {
        return;
    }

    const texture = new THREE.VideoTexture(video);
    texture.colorSpace = THREE.SRGBColorSpace;
    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0.1, 10);
    camera.position.z = 1;
    const uniforms = {
        footage: { value: texture },
        pointer: { value: new THREE.Vector2(0.5, 0.5) },
        strength: { value: 0 },
        fit: { value: new THREE.Vector2(1, 1) },
    };
    const material = new THREE.ShaderMaterial({
        uniforms,
        vertexShader: `varying vec2 videoUv;
            void main() {
                videoUv = uv;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }`,
        fragmentShader: `uniform sampler2D footage;
            uniform vec2 pointer;
            uniform vec2 fit;
            uniform float strength;
            varying vec2 videoUv;
            void main() {
                vec2 uv = (videoUv - 0.5) / fit + 0.5;
                vec2 delta = videoUv - pointer;
                float influence = exp(-dot(delta, delta) * 28.0);
                vec3 original = sRGBTransferEOTF(texture2D(footage, clamp(uv, 0.0, 1.0))).rgb;
                float depth = dot(original, vec3(0.2126, 0.7152, 0.0722));
                float edge = smoothstep(0.0, 0.12, min(min(uv.x, uv.y), min(1.0-uv.x, 1.0-uv.y)));
                uv += (delta * influence * 0.095 + (pointer - 0.5) * depth * 0.022) * strength * edge;
                if (min(uv.x, uv.y) < 0.0 || max(uv.x, uv.y) > 1.0) {
                    gl_FragColor = vec4(0.0);
                } else {
                    gl_FragColor = vec4(sRGBTransferEOTF(texture2D(footage, uv)).rgb, 1.0);
                }
                #include <tonemapping_fragment>
                #include <colorspace_fragment>
            }`,
        transparent: true,
        toneMapped: false,
    });
    const geometry = new THREE.PlaneGeometry(2, 2);
    scene.add(new THREE.Mesh(geometry, material));
    host.append(renderer.domElement);
    const target = new THREE.Vector2(0.5, 0.5);
    let hovering = false;
    let visible = false;
    let frame = 0;
    let lastTime = 0;
    let disposed = false;

    const render = (time) => {
        frame = 0;
        if (disposed || !visible || document.hidden) return;
        const smoothing = 1 - Math.exp(-Math.min((time - lastTime) / 1000, 0.05) * 9);
        lastTime = time;
        uniforms.pointer.value.lerp(target, smoothing);
        uniforms.strength.value = THREE.MathUtils.lerp(uniforms.strength.value, hovering ? 1 : 0, smoothing);
        if (video.readyState >= 2) {
            renderer.render(scene, camera);
            host.classList.add('is-interactive');
        }
        frame = requestAnimationFrame(render);
    };
    const schedule = () => {
        cancelAnimationFrame(frame);
        frame = 0;
        lastTime = performance.now();
        if (visible && !document.hidden && !disposed) frame = requestAnimationFrame(render);
    };
    const resize = () => {
        const width = host.clientWidth;
        const height = host.clientHeight;
        if (!width || !height) return;
        renderer.setPixelRatio(window.devicePixelRatio || 1);
        renderer.setSize(width, height, false);
        const ratio = video.videoWidth / video.videoHeight || 1;
        const areaRatio = width / height;
        uniforms.fit.value.set(Math.max(ratio / areaRatio, 1), Math.max(areaRatio / ratio, 1));
    };
    const move = (event) => {
        if (event.pointerType === 'touch') return;
        const bounds = host.getBoundingClientRect();
        target.set((event.clientX - bounds.left) / bounds.width, 1 - (event.clientY - bounds.top) / bounds.height);
        hovering = true;
    };
    const leave = () => { hovering = false; target.set(0.5, 0.5); };
    const observer = new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; schedule(); });
    const sizes = new ResizeObserver(resize);
    const dispose = () => {
        if (disposed) return;
        disposed = true;
        cancelAnimationFrame(frame);
        observer.disconnect();
        sizes.disconnect();
        host.classList.remove('is-interactive');
        host.removeEventListener('pointermove', move);
        host.removeEventListener('pointerleave', leave);
        video.removeEventListener('loadedmetadata', resize);
        document.removeEventListener('visibilitychange', schedule);
        motion.removeEventListener('change', preferenceChanged);
        window.removeEventListener('pagehide', pageHidden);
        geometry.dispose();
        material.dispose();
        texture.dispose();
        renderer.dispose();
        renderer.domElement.remove();
    };
    const preferenceChanged = () => { if (motion.matches) dispose(); };
    const pageHidden = (event) => { if (!event.persisted) dispose(); };
    renderer.domElement.addEventListener('webglcontextlost', dispose, { once: true });
    video.addEventListener('error', dispose, { once: true });
    video.addEventListener('loadedmetadata', resize);
    host.addEventListener('pointermove', move, { passive: true });
    host.addEventListener('pointerleave', leave);
    document.addEventListener('visibilitychange', schedule);
    motion.addEventListener('change', preferenceChanged);
    window.addEventListener('pagehide', pageHidden);
    sizes.observe(host);
    observer.observe(host);
    resize();
}
