<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <META http-equiv=Content-Type content="text/html; charset=utf-8">
    <title>{$title}</title>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/navication.css" />
    <script src="/js/navication.js" type="text/javascript"></script>
    <script language="javascript">
        commonAjaxUrl = '{$smarty.const.COMMON_AJAX_URL}';
    </script>
    {literal}
        <script type="text/javascript">
            function submitCheck() {
                choice = $('#choice option:selected').val();
                content = $('#fromContent').val();
                if (content == '') {
                    alert('content is empty!');
                } else {
                    $.ajax({
                        type: "post",
                        async: false,
                        data:{'choice' : choice, 'content' : content},
                        url: commonAjaxUrl + "?act=rsynch-string-change",
                        success: function (result) {
                            $('#toContent').val(result);
                        }
                    });
                }
            }
        </script>
        <style>
            th{align:center;background:#525274;color:#FFFFFF;}
            .row_odd td{background-color:#FFFFFF;}
            .row_even td{background-color:#EEEEEE;border:1px solid #DDDDDD; }
            .td_value{text-align:left;background-color:#FFFFFF;border:1px solid #DDDDDD;}
            .td_label{text-align:right;background-color:#EEEEEE;border:1px solid #DDDDDD;font-weight:bold;}
            .sub{padding-left:10px;}
            .btn_large{width:120px;height:40px;font-family:Tahoma,Arial;font-size:16px;}
        </style>
    {/literal}
</head>
<body>
{include file='navication.tpl'}
<form action="" method="post">
    <div align="center" style="font-weight:bold;font-size:16px;line-height:28px;line-height:40px;">
        {$title}</span>
    </div>
    <table width="99%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E8E8FF" align="center" style="border:1px solid #DDDDDD">
        <tr><th colspan="2"><b>Detail Info</b></th></tr>
        <tr>
            <td class="td_label" onmouseover="this.style.backgroundColor='#FBF0E3';" onmouseout="this.style.backgroundColor='#EEEEEE'">
                Choice
            </td>
            <td class="td_value" onmouseover="this.style.backgroundColor='#FBF0E3';" onmouseout="this.style.backgroundColor='#FFFFFF'">
                <select name="choice" id="choice">
                    {html_options options=$choiceArray}
                </select>
            </td>
        </tr>
        <tr>
            <td class="td_label" onmouseover="this.style.backgroundColor='#FBF0E3';" onmouseout="this.style.backgroundColor='#EEEEEE'">
                Content
            </td>
            <td class="td_value" onmouseover="this.style.backgroundColor='#FBF0E3';" onmouseout="this.style.backgroundColor='#FFFFFF'">
                from:<textarea cols="40px" rows="10px" name="fromContent" id="fromContent"></textarea>
                to:<textarea cols="40px" rows="10px" name="toContent" id="toContent"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" name="Submit" value="Change" class="btn_large"  onclick="submitCheck();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" name="Reset" value="Reset">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
