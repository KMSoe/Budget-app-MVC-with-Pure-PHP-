// Date, Month, Year Pickers
$(document).ready(function () {
    $("#yearpicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });
    $("#monthpicker").datepicker({
        format: "M yyyy",
        viewMode: "years",
        minViewMode: "months",
    });
    $("#firstdatepicker").datepicker();
    $("#seconddatepicker").datepicker();

});