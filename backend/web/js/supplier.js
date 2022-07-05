/**
 * 标识选中所有页面过滤行
 */
function selectAllPage() {
    $("#selected_all_page").attr("value", 1);
    noticeHide();
}

/**
 * 标识选中所有页面过滤行取消
 */
function selectAllPageCancel() {
    $("#selected_all_page").attr("value", 0);
}

/**
 * 取消选中
 */
function cancelSelect(){
    if ($("[name='selection_all']").is(':checked')){
        $("[name='selection_all']").click();
    }
}

/**
 * 展示提示
 */
function noticeShow(){
    $("#select_all_notice").html('<strong>当前页面所有过滤行已被选中。</strong><a class="text-decoration" onclick="selectAllPage()">选中所有页面过滤行</a> / <a class="text-decoration" onclick="cancelSelect()">取消所有选中行</a>')
    $("#select_all_notice").attr("style", "display:block")
}

/**
 * 隐藏提示信息
 */
function noticeHide(){
    $("#select_all_notice").attr("style", "display:none")
}

/**
 * 导出
 */
function doExport(){
    // 是否选中所有过滤行
    let select_all = $("#selected_all_page").val();
    // 选中的id
    let ids = $('#grid').yiiGridView('getSelectedRows');
    // 导出字段
    let columns = [];
    $("[name='export[column][]']").each(function () {
        if ($(this).is(':checked')){
            columns.push($(this).val());
        }
    })
    // 过滤条件
    let filter = {
        "id_range_tag":$("[name='SupplierSearch[id_range_tag]']").val(),
        "id":$("[name='SupplierSearch[id]']").val(),
        "name":$("[name='SupplierSearch[name]']").val(),
        "code":$("[name='SupplierSearch[code]']").val(),
        "t_status":$("[name='SupplierSearch[t_status]']").val(),
    };

    $.post('/supplier/export', {select_all:select_all, ids:ids, columns:columns, filter:filter}, function (result) {
        console.log(result);
        if (result.code == 200){
            window.location.href = result.data.url;
        }else{
            alert(result.message);
        }
    }, 'json');
}

$(document).ready(function(){

    // 选中所有事件
    $("[name='selection_all']").click(function (e) {
        if ($("[name='selection_all']").is(':checked')){
            noticeShow();
        }else{
            selectAllPageCancel();
            noticeHide();
        }
    })

    // checkbox选中事件
    $("[name='selection[]']").click(function (e) {
        // 选中数量
        let ids = $('#grid').yiiGridView('getSelectedRows');
        let selectCount = ids.length;

        // 页面容量
        let pageSize = parseInt($("#pageSize").val());
        // 数据总量
        let total = parseInt($("#total").val());

        console.log(selectCount, pageSize, total)
        // 全部选中
        if (selectCount === pageSize || selectCount === total){
            noticeShow();
        }
    })
});



