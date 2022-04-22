<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $ApplicationSetting->item_name }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p class="my-0 font-weight-bold">@lang('Are You Sure You Want To Delete This Data') ???</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Close')</button>
                    <form class="btn-ok" action="" method="post">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#myModal").on("show.bs.modal", function (e) {
            $(this).find(".btn-ok").attr("action", $(e.relatedTarget).data("href"));
        });
    });
</script>
