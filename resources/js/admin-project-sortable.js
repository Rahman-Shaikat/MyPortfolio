import Sortable from 'sortablejs';

const projectList = document.querySelector('[data-project-sortable]');

if (projectList) {
    const status = document.querySelector('[data-project-sort-status]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    let previousOrder = [];

    const projectIds = () => [...projectList.querySelectorAll('[data-project-id]')]
        .map((row) => Number(row.dataset.projectId));

    const showStatus = (message, isError = false) => {
        if (!status) {
            return;
        }

        status.textContent = message;
        status.classList.toggle('text-danger', isError);
        status.classList.toggle('text-success', !isError && message !== 'Saving...');
    };

    const restoreOrder = () => {
        const rows = new Map(
            [...projectList.querySelectorAll('[data-project-id]')]
                .map((row) => [Number(row.dataset.projectId), row]),
        );

        previousOrder.forEach((projectId) => {
            const row = rows.get(projectId);

            if (row) {
                projectList.append(row);
            }
        });
    };

    Sortable.create(projectList, {
        animation: 180,
        handle: '.admin-project-drag-handle',
        ghostClass: 'admin-project-sort-ghost',
        chosenClass: 'admin-project-sort-chosen',
        dragClass: 'admin-project-sort-dragging',
        onStart: () => {
            previousOrder = projectIds();
            showStatus('');
        },
        onEnd: async (event) => {
            if (event.oldIndex === event.newIndex) {
                return;
            }

            showStatus('Saving...');

            try {
                const response = await fetch(projectList.dataset.reorderUrl, {
                    method: 'PATCH',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ projects: projectIds() }),
                });

                if (!response.ok) {
                    throw new Error('The project order could not be saved.');
                }

                showStatus('Order saved.');
            } catch (error) {
                restoreOrder();
                showStatus(error.message, true);
            }
        },
    });
}
