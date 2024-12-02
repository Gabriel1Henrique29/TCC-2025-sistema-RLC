document.getElementById('submit-button').addEventListener('click', function () {
    const rows = document.querySelectorAll('#student-list .table-row');
    let attendanceResult = '';

    rows.forEach((row, index) => {
        const studentName = row.querySelector('.student-name').textContent;
        const presentChecked = row.querySelectorAll('.attendance-radio')[0].checked;
        const absentChecked = row.querySelectorAll('.attendance-radio')[1].checked;

        if (presentChecked) {
            attendanceResult += `${studentName}: Presente<br>`;
        } else if (absentChecked) {
            attendanceResult += `${studentName}: Ausente<br>`;
        } else {
            attendanceResult += `${studentName}: Não marcado<br>`;
        }
    });

    document.getElementById('result').innerHTML = attendanceResult;
});
