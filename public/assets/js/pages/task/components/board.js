export default class Board {
    constructor(tasks) {
        this.tasks = tasks;

        this.extract();
    }

    extract() {
        const _this = this;
        const nottings = [];
        const inProgress = [];
        const dones = [];
        const tasks = this.tasks;
        tasks.forEach(task => {
            switch (task.status) {
                case 'notting':
                    nottings.push(_this.item(task));
                    break;
                case 'in_progress':
                    inProgress.push(_this.item(task));
                    break;
                case 'done':
                    dones.push(_this.item(task));
                    break;
            }
        });

        const boards = [];
        boards.push({
            'id': '_notting',
            'title': 'Notting',
            'class': 'bg-light-dark',
            'item': nottings,
        });
        boards.push({
            'id': '_in_progress',
            'title': 'In Progress',
            'class': 'bg-light-warning',
            'item': inProgress,
        });
        boards.push({
            'id': '_done',
            'title': 'Done',
            'class': 'bg-light-success',
            'item': dones,
        });
        _this.boards = boards;
    }

    item(task) {
        return {
            'title': `
                <div class="d-flex align-items-center position-relative" data-item-key="${task.id}">
                    <div class="d-flex flex-column align-items-start">
                        <span class="badge badge-light-success" id="feature">${task.feature.name}</span>
                        <span class="text-dark-50 mt-1" id="content">${task.content}</span>
                    </div>
                    <div class="position-absolute" style="top: -20px; right: 0;">
                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger w-20px h-20px p-0" data-key="${task.id}" id="btn-delete">
                            <i class="ki-duotone ki-trash fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                                <i class="path4"></i>
                                <i class="path5"></i>
                            </i>
                        </button>
                    </div>
                    <div class="position-absolute" style="top: -20px; right: -20px;">
                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary w-20px h-20px p-0" data-key="${task.id}" id="btn-edit">
                            <i class="ki-duotone ki-notepad-edit fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                            </i>
                        </button>
                    </div>
                </div>
            `,
        };
    }
}
