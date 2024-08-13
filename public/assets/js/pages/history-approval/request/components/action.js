const btnShow = (key) => {
    return `
        <a href="/history-approvals/requests/${key}/show" class="btn btn-sm btn-warning ps-4 d-flex">
        <i class="ki-duotone ki-eye fs-3">
            <i class="path1"></i>
            <i class="path2"></i>
            <i class="path3"></i>
        </i>Show</a>
    `;
}
const action = (data, type, row) => {
    var btns = '';
    btns += btnShow(row.id);
    return '<div class="d-flex align-items-center gap-2">' + btns + '</div>';
}

export { action }

