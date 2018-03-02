<!-- <script src="{{ url('quickadmin/js') }}/jquery.js"></script> -->
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<script src="{{ url('quickadmin/js') }}/jquery-ui.js"></script>
<script src="{{ url('quickadmin/js') }}/bootstrap.min.js"></script>
<script src="{{ url('quickadmin/js') }}/main.js"></script>
<script src="{{ url('quickadmin/js') }}/jeDate/jquery.jedate.js"></script>
<script src="{{ url('quickadmin/js') }}/My97DatePicker/WdatePicker.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->
<script src="{{ url('quickadmin/js') }}/select2.js"></script>
<script>
    window._token = '{{ csrf_token() }}';
</script>
<script>
    $(document).ready(function() {
        var role;
        $.get("/userinfo",function(data, status) {
            if (data.role_id == 1) role = '管理员';
            if (data.role_id == 2) role = '参试者';
            if (data.role_id == 3) role = '老师';
            $("#role").text(role + ': ' + data.name);
        });
        $("#type").select2({
            tags: true,
            maximumSelectionLength: 3 //最多能够选择的个数
        });
        $("#mulType").select2({
            tags: true,
            maximumSelectionLength: 4 //最多能够选择的个数
        });
        $("#type").on("change", function(e) {
            if ($("#type").val() == 2) { // 多选
                $("#mult").removeClass('hide'); // 多选
                $("#simple").addClass('hide'); // 单选
                $("#judge").addClass('hide');
                $("#option").removeClass('hide');
            } else if ($("#type").val() == 1) { // 单选
                $("#mult").addClass('hide'); // 多选
                $("#simple").removeClass('hide'); // 单选
                $("#judge").addClass('hide');
                $("#option").removeClass('hide');
            } else if ($("#type").val() == 3) { // 判断
                $("#simple").addClass('hide');
                $("#option").addClass('hide');
                $("#mult").addClass('hide');
                $("#judge").removeClass('hide');
            }
         })  // 改变事件 
    });
</script>

@yield('javascript')