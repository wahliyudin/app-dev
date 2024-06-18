const btnEdit = (key) => {
    return `
        <a href="/requests/${key}/edit" class="btn btn-sm btn-primary ps-4 d-flex"><i
            class="ki-duotone ki-notepad-edit fs-3">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>Edit</a>
    `;
}
const btnDelete = (key) => {
    return `
        <button type="button" data-key="${key}" class="btn btn-sm btn-danger ps-4" id="btn-delete">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-trash fs-3">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                        <i class="path4"></i>
                        <i class="path5"></i>
                    </i>Delete
                </div>
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    `;
}
const action = (data, type, row) => {
    var btns = '';
    if (data.is_edit) {
        btns += btnEdit(row.id);
    }
    if (data.is_delete) {
        btns += btnDelete(row.id);
    }
    return '<div class="d-flex align-items-center gap-2">' + btns + '</div>';
}

export { action }

