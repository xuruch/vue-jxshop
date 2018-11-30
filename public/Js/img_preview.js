// 当选择图片时触发
$(".preview").change(function(){
    // 获取选择的图片
    var file = this.files[0];
    console.log(file)
    // 转成字符串
    var str = getObjectUrl(file);
    // 先删除上一个
    $(this).prev('.img_preview').remove();
    // 在框的前面放一个图片
    $(this).before("<div class='img_preview'><img src='"+str+"' width='120' height='120'></div>");
});

// 把图片转成一个字符串
function getObjectUrl(file) {
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file)
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file)
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file)
    }
    return url
}