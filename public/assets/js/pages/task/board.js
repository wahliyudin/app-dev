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
        task.due_date_badge = this.badgeDueDate(task.due_date, task.status);
        return {
            'title': `
                <div class="d-flex flex-column position-relative" data-item-key="${task.key}">
                    <div class="d-flex flex-column align-items-start">
                        <span class="badge badge-light" id="feature">${task.feature_name}</span>
                        <span class="text-dark-50 mt-1" id="content">${task.content}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div class="symbol-group symbol-hover">
                            ${this.convertDevelopers(task.developers)}
                        </div>
                        ${task.due_date_badge}
                    </div>
                    <div class="position-absolute" style="top: -20px; right: 0;">
                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger w-20px h-20px p-0" data-key="${task.key}" id="btn-delete">
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
                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary w-20px h-20px p-0" data-key="${task.key}" id="btn-edit">
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

    badgeDueDate(due_date, status) {
        const now = moment().format('YYYY-MM-DD');
        const dueDate = moment(due_date);
        const diffInDays = Math.round(dueDate.diff(now, 'days', true));
        var text = "Due today";
        var badge = "badge-light-warning";
        if (status === 'done') {
            text = "Done";
            badge = "badge-light-success";
        } else if (due_date < now) {
            text = "Overdue";
            badge = "badge-light-danger";
        } else if (diffInDays > 0) {
            text = `Due in ${diffInDays} days`;
            badge = "badge-light-primary";
        }
        return `<span class="badge ${badge}" data-date="${due_date}" data-status="${status}" id="due_date">${text}</span>`;
    }

    convertDevelopers(developers) {
        return developers.map(developer => {
            return `<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-nik="${developer.nik}" title="${developer.name}">
                        <img alt="Pic" src="${developer.avatar}" />
                    </div>`;
        }).join('');
    }
}
