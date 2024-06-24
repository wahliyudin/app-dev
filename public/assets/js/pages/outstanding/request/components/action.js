const btnSetting = (key) => {
    return `
        <a href="/outstandings/requests/${key}/setting" class="btn btn-sm btn-info ps-4 d-flex">
        <i class="ki-duotone ki-setting-2 fs-3">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>Setting</a>
    `;
}
const action = (data, type, row) => {
    var btns = '';
    btns += btnSetting(row.id);
    return '<div class="d-flex align-items-center gap-2">' + btns + '</div>';
}

export { action }

