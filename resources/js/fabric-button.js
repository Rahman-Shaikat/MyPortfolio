import * as THREE from 'three';

export function initFabricButton(button) {
    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    } catch { return; }
    renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
    renderer.domElement.className = 'fabric-button-canvas';
    renderer.domElement.setAttribute('aria-hidden', 'true');
    button.prepend(renderer.domElement);
    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1.8, 1.8, 1, -1, 0.1, 20);
    camera.position.set(0, 0, 5);
    scene.add(new THREE.HemisphereLight(0xf3fff8, 0x12372c, 1.8));
    const light = new THREE.DirectionalLight(0xffffff, 2.5);
    light.position.set(-2, 4, 5);
    scene.add(light);

    // A rounded superellipsoid provides real volume along the fabric's edges.
    const geometry = new THREE.SphereGeometry(1, 72, 48);
    const positions = geometry.attributes.position;
    const power = (v, exponent) => Math.sign(v) * Math.pow(Math.abs(v), exponent);
    for (let i = 0; i < positions.count; i++) {
        positions.setXYZ(i, power(positions.getX(i), 0.5) * 1.43,
            power(positions.getY(i), 0.65) * 0.56, power(positions.getZ(i), 0.75) * 0.23);
    }
    const base = positions.array.slice();
    geometry.computeVertexNormals();
    const grain = document.createElement('canvas');
    grain.width = grain.height = 128;
    const context = grain.getContext('2d');
    const pixels = context.createImageData(128, 128);
    let seed = 31;
    for (let i = 0; i < pixels.data.length; i += 4) {
        seed = (Math.imul(seed, 1664525) + 1013904223) >>> 0;
        const value = 215 + (seed % 41);
        pixels.data.set([value, value, value, 255], i);
    }
    context.putImageData(pixels, 0, 0);
    const texture = new THREE.CanvasTexture(grain);
    texture.wrapS = texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(1.5, 1);
    texture.colorSpace = THREE.SRGBColorSpace;
    const material = new THREE.MeshPhysicalMaterial({
        color: getComputedStyle(button).getPropertyValue('--accent').trim() || '#a7e8ce',
        roughness: 1, metalness: 0, map: texture, bumpMap: texture, bumpScale: 0.006,
        sheen: 1, sheenColor: 0xd8ffea, sheenRoughness: 0.85,
    });
    const cushion = new THREE.Mesh(geometry, material);
    scene.add(cushion);
    const motion = matchMedia('(prefers-reduced-motion: reduce)');
    const target = new THREE.Vector2();
    const pointer = new THREE.Vector2();
    let hovered = false;
    let pressed = false;
    let amount = 0;
    let velocity = 0;
    let frame = 0;
    let previous = 0;
    let disposed = false;
    let visible = true;

    const render = (time) => {
        frame = 0;
        if (disposed || document.hidden || !visible) return;
        const dt = Math.min((time - previous) / 1000 || 0.016, 0.035);
        previous = time;
        const goal = motion.matches ? 0 : pressed ? -0.35 : hovered ? 1 : 0;
        velocity += ((goal - amount) * 95 - velocity * 15) * dt;
        amount += velocity * dt;
        material.bumpScale = 0.006 + Math.max(0, amount) * 0.016;
        pointer.lerp(target, 1 - Math.exp(-dt * 12));
        for (let i = 0; i < positions.count; i++) {
            const offset = i * 3;
            const x = base[offset], y = base[offset + 1], z = base[offset + 2];
            const dx = x - pointer.x, dy = y - pointer.y;
            const influence = Math.exp(-(dx * dx * 1.5 + dy * dy * 3));
            const front = Math.max(0, z / 0.23);
            const folds = Math.sin(y * 27 + x * 4 - time * 0.0025) * 0.045 * influence;
            positions.setXYZ(i,
                x + amount * (x * 0.016 + pointer.x * influence * 0.065),
                y + amount * (y * 0.07 + pointer.y * influence * 0.26),
                z + amount * front * (0.07 + influence * 0.17 + folds));
        }
        positions.needsUpdate = true;
        geometry.computeVertexNormals();
        cushion.rotation.x = -pointer.y * amount * 0.045;
        cushion.rotation.y = pointer.x * amount * 0.035;
        renderer.render(scene, camera);
        button.classList.add('has-fabric-surface');
        if (!motion.matches && (hovered || Math.abs(amount - goal) > 0.001 || Math.abs(velocity) > 0.001)) {
            frame = requestAnimationFrame(render);
        }
    };
    const schedule = () => {
        if (!frame && !disposed) { previous = performance.now(); frame = requestAnimationFrame(render); }
    };
    const move = (event) => {
        if (event.pointerType === 'touch' || motion.matches) return;
        const bounds = button.getBoundingClientRect();
        target.set(((event.clientX - bounds.left) / bounds.width - 0.5) * 2.86,
            (0.5 - (event.clientY - bounds.top) / bounds.height) * 1.12);
        hovered = true;
        schedule();
    };
    const leave = () => { hovered = pressed = false; schedule(); };
    const down = () => { pressed = true; schedule(); };
    const up = () => { pressed = false; schedule(); };
    const focus = () => { if (button.matches(':focus-visible')) { hovered = true; target.set(0, 0); schedule(); } };
    const resize = () => {
        const width = button.offsetWidth + 28, height = button.offsetHeight + 28;
        renderer.setSize(width, height, false);
        camera.left = -1.43 * width / button.offsetWidth;
        camera.right = -camera.left;
        camera.top = 0.56 * height / button.offsetHeight;
        camera.bottom = -camera.top;
        camera.updateProjectionMatrix();
        schedule();
    };
    const preferences = () => { if (motion.matches) { amount = velocity = 0; hovered = pressed = false; } schedule(); };
    const sizes = new ResizeObserver(resize);
    sizes.observe(button);
    const observer = new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; schedule(); });
    observer.observe(button);
    button.addEventListener('pointermove', move, { passive: true });
    button.addEventListener('pointerleave', leave);
    button.addEventListener('pointercancel', leave);
    button.addEventListener('pointerdown', down);
    window.addEventListener('pointerup', up);
    button.addEventListener('focus', focus);
    button.addEventListener('blur', leave);
    document.addEventListener('visibilitychange', schedule);
    motion.addEventListener('change', preferences);
    const dispose = () => {
        disposed = true;
        cancelAnimationFrame(frame);
        sizes.disconnect(); observer.disconnect();
        button.classList.remove('has-fabric-surface');
        button.removeEventListener('pointermove', move);
        button.removeEventListener('pointerleave', leave);
        button.removeEventListener('pointercancel', leave);
        button.removeEventListener('pointerdown', down);
        button.removeEventListener('focus', focus);
        button.removeEventListener('blur', leave);
        window.removeEventListener('pointerup', up);
        document.removeEventListener('visibilitychange', schedule);
        motion.removeEventListener('change', preferences);
        geometry.dispose(); material.dispose(); texture.dispose(); renderer.dispose();
        renderer.domElement.remove();
    };
    renderer.domElement.addEventListener('webglcontextlost', dispose, { once: true });
    window.addEventListener('pagehide', (event) => { if (!event.persisted) dispose(); });
    resize();
}
