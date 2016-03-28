$(document).ready(function () {
    $('tr').click(function () {
        location.assign("http://localhost/darflow_final/view.php?doc_id=" + $(this).children('td:first-child').text());
    });
});
