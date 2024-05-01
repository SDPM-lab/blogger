<?= $this->extend("TodoList/template") ?>
<?= $this->section('content') ?>
<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title col-9">TodoList</h3>
        <div class="col-2" style="text-align:right">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#createMessageModal">Create</button>
        </div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="messageDataTable">
            <thead>
                <tr>
                    <th class="text-center" style="width:10%;">#</th>
                    <th style="width: 25%;">Title</th>
                    <th class="d-none d-sm-table-cell" style="width: 40%;">Content</th>
                    <th class="d-none d-sm-table-cell" style="width: 20%;">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<!-- END Dynamic Table Full -->
<!-- Fade In Block Modal -->
<div class="modal fade" id="createMessageModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Create a new TodoList</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row push">
                        <div class="col-lg-12 col-xl-12">
                            <form id="createForm">
                                <div class="form-group">
                                    <label for="createTitle">Title</label>
                                    <input type="text" class="form-control" id="createTitle" name="createTitle" placeholder="Title Input">
                                </div>
                                <div class="form-group">
                                    <label for="createContent">Content</label>
                                    <textarea class="form-control" id="createContent" name="createContent" rows="4" placeholder="Content Input..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="todoComponent.create()">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Fade In Block Modal -->
<!-- Large Default Modal -->
<div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modify Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="block-content">
                <div class="row push">
                    <div class="col-lg-12 col-xl-12">
                        <form id="modifyForm">
                            <div class="form-group">
                                <label for="modifyTitle">Title</label>
                                <input type="text" class="form-control" id="modifyTitle" name="modifyTitle" placeholder="Title Input">
                            </div>
                            <div class="form-group">
                                <label for="modifyContent">Content</label>
                                <textarea class="form-control" id="modifyContent" name="modifyContent" rows="4" placeholder="Content Input..."></textarea>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="modifyKey">Key</label>
                                <input type="text" class="form-control" id="modifyKey" name="modifyKey" placeholder="Title Input">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="todoComponent.put()">Modify</button>
            </div>
        </div>
    </div>
</div>
<!-- END Large Default Modal -->
<script type=text/javascript>
    let messageTable;

    $(document).ready(function() {
        messageTable = getDataTable();
    });

    let getDataTable = () => {
        return $('#messageDataTable').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [3]
            }],
            "order": [],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('todoList/getDataTable') ?>",
                type: 'GET'
            }
        });
    }

    let todoComponent = {
        create: function() {
            event.preventDefault();
            Swal.fire({
                title: '確定要新增嗎',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    if ($('#createTitle').val() == '' || $('#createContent').val() == '') {
                        Swal.fire({
                            icon: 'error',
                            title: '錯誤',
                            text: '需輸入標題以及內容'
                        })
                    } else {
                        data = {
                            'title': $('#createTitle').val(),
                            'content': $('#createContent').val()
                        }

                        axios.post('<?= base_url("api/v1/todo") ?>', JSON.stringify(data))
                            .then((response) => {
                                messageTable.ajax.reload();

                                Swal.fire(
                                    '新增成功!',
                                    '',
                                    'success'
                                )

                                $('#createMessageModal').modal('hide');
                                $('#createTitle').val("");
                                $('#createContent').val("");
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: 'error',
                                    title: error.response.data.status + ' 錯誤',
                                    text: error.response.data.messages.error
                                })
                            })
                    }
                }
            })
        },
        show: function(key) {
            axios.get('<?= base_url("api/v1/todo/") ?>' + key)
                .then((response) => {
                    let data = response.data.data;
                    $('#modifyTitle').val(data['title']);
                    $('#modifyContent').val(data['content']);
                    $('#modifyKey').val(data['key']);
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: error.response.data.status + ' 錯誤',
                        text: error.response.data.messages.error
                    })
                })
        },
        put: function() {
            Swal.fire({
                title: '確定要修改嗎',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    if ($('#modifyTitle').val() == '' || $('#modifyContent').val() == '') {
                        Swal.fire({
                            icon: 'error',
                            title: '錯誤',
                            text: '需輸入標題以及內容'
                        })
                    } else {
                        let modifyData = {
                            "title": $('#modifyTitle').val(),
                            "content": $('#modifyContent').val(),
                            "key": $('#modifyKey').val()
                        }

                        axios.put('<?= base_url("api/v1/todo/") ?>' + modifyData.key, JSON.stringify(modifyData))
                            .then((response) => {
                                messageTable.ajax.reload();

                                Swal.fire(
                                    '修改成功!',
                                    '',
                                    'success'
                                )
                                $('#modifyModal').modal('hide');
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: 'error',
                                    title: error.response.data.status + ' 錯誤',
                                    text: error.response.data.messages.error
                                })
                            })
                    }
                }
            })
        },
        delete: function(key) {
            Swal.fire({
                title: '確定要刪除嗎',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '確定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('<?= base_url("api/v1/todo/") ?>' + key)
                        .then((response) => {
                            messageTable.ajax.reload();

                            Swal.fire(
                                '刪除成功!',
                                '',
                                'success'
                            )
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: 'error',
                                title: error.response.data.status + ' 錯誤',
                                text: error.response.data.messages.error
                            })
                        })
                }
            })
        }
    }
</script>
<?= $this->endSection() ?>