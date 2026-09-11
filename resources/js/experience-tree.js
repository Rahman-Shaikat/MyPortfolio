import * as THREE from 'three';

export function initExperienceTree(tree) {
    const items = [...tree.querySelectorAll('article')];
    const host = tree.querySelector('.experience-tree-scene');
    if (!items.length) return;

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    } catch {
        return;
    }
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    host.append(renderer.domElement);
    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(0, 40, 0, 1, 0.1, 100);
    camera.position.z = 20;
    const material = new THREE.MeshBasicMaterial({ color: '#a7e8ce', side: THREE.DoubleSide });
    const connections = items.slice(1).map(() => {
        const line = new THREE.Mesh(new THREE.PlaneGeometry(3, 1), material);
        line.position.set(15.5, 0, -1);
        scene.add(line);
        return line;
    });
    const nodes = items.map(() => {
        const node = new THREE.Mesh(new THREE.SphereGeometry(6, 20, 12), material);
        node.position.x = 15.5;
        scene.add(node);
        return node;
    });
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let height = 1;
    let progress = 0;
    let startTime;
    let frame;
    let started = false;

    const render = () => {
        const step = progress * connections.length;
        connections.forEach((line, index) => {
            const fraction = Math.min(Math.max(step - index, 0), 1);
            const eased = fraction * fraction * (3 - 2 * fraction);
            const start = nodes[index].position.y;
            const length = (nodes[index + 1].position.y - start) * eased;
            line.visible = length > 0;
            line.scale.y = Math.max(length, 0.001);
            line.position.y = start + length / 2;
        });
        nodes.forEach((node, index) => {
            node.visible = started && step >= index;
            if (node.visible) items[index].classList.add('is-shown');
        });
        renderer.render(scene, camera);
    };
    const resize = () => {
        height = tree.offsetHeight;
        renderer.setSize(40, height);
        camera.bottom = height;
        camera.updateProjectionMatrix();
        nodes.forEach((node, index) => { node.position.y = items[index].offsetTop + 24; });
        render();
    };
    const animate = (time) => {
        startTime ??= time;
        progress = reducedMotion.matches ? 1 : Math.min((time - startTime) / (Math.max(connections.length, 1) * 950), 1);
        render();
        if (progress < 1) frame = requestAnimationFrame(animate);
    };
    const observer = new IntersectionObserver(([entry]) => {
        if (!entry.isIntersecting || started) return;
        started = true;
        frame = requestAnimationFrame(animate);
        observer.disconnect();
    }, { threshold: 0.15 });
    tree.classList.add('is-enhanced');
    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(tree);
    resize();
    observer.observe(tree);
    renderer.domElement.addEventListener('webglcontextlost', (event) => {
        event.preventDefault();
        cancelAnimationFrame(frame);
        tree.classList.remove('is-enhanced');
        host.hidden = true;
    });
}
