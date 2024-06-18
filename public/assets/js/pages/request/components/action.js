const btnSetting = (key) => {
    return `<a href="/settings/access-permission/${key}/edit" class="btn btn-sm btn-primary ps-2">
        <i class="ki-duotone ki-setting-2 fs-2">
            <i class="path1"></i>
            <i class="path2"></i>
        </i>Setting</a>
    `;
}
const action = (data, type, row) => {
    var btns = '';
    if (data.is_setting) {
        btns += btnSetting(row.nik);
    }
    return '<div class="d-flex align-items-center gap-2">' + btns + '</div>';
}

export { action }

