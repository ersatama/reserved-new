
@if (config('backpack.base.scripts') && count(config('backpack.base.scripts')))
    @foreach (config('backpack.base.scripts') as $path)
    <script type="text/javascript" src="{{ asset($path).'?v='.config('backpack.base.cachebusting_string') }}"></script>
    @endforeach
@endif

@if (config('backpack.base.mix_scripts') && count(config('backpack.base.mix_scripts')))
    @foreach (config('backpack.base.mix_scripts') as $path => $manifest)
    <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

@include('backpack::inc.alerts')
<div class="modal fade" id="booking-modal" tabindex="-1" role="dialog" aria-labelledby="booking-modal" aria-hidden="true" data-id="" data-organization="">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-sm rounded-lg overflow-hidden">
            <div class="modal-header border-0 bg-success rounded-0">
                <h5 class="modal-title font-weight-bold" id="booking-modal">Бронирование столика</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="phone">Номер телефона</label>
                            <input type="text" class="form-control radius" id="phone" onblur="phoneCheck()">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control radius" id="name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date">Дата</label>
                            <input type="email" class="form-control radius" id="date" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time">Время (00:00 - 23:59)</label>
                            <input type="text" class="form-control radius" id="time">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-block m-0 mr-2 close-booking" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-success btn-block m-0 ml-2 new-booking">Забронировать</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .ui-datepicker {
        padding: 15px;
        border: none;
        box-shadow: 0 0 5px 0 rgba(0,0,0,.1);
    }
    .radius {
        border: none;
        border-radius: 5px;
        background-color: #f5f7fa;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js" integrity="sha512-yVcJYuVlmaPrv3FRfBYGbXaurHsB2cGmyHr4Rf1cxAS+IOe/tCqxWY/EoBKLoDknY4oI1BNJ1lSU2dxxGo9WDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/notify.min.js"></script>
<script>
    let status = true;
    $(".new-booking").bind('click', function() {

        if (status) {
            let phone   =   $("#phone");
            let name    =   $("#name");
            let date    =   $("#date");
            let time    =   $("#time");
            if (phone.val().trim() === '') {
                return phone.focus();
            } else if (name.val().trim() === '') {
                return name.focus();
            } else if (date.val().trim() === '') {
                return date.focus();
            } else if (time.val().trim() === '') {
                return time.focus();
            }
            let data    =   {
                timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                user_id: $("#booking-modal").attr('data-user'),
                organization_id: $("#booking-modal").attr('data-organization'),
                organization_table_id: $("#booking-modal").attr('data-id'),
                phone: phone.val().trim(),
                name:  name.val().trim(),
                date:  date.val().trim(),
                time:  time.val().trim(),
            };
            status = false;
            $.ajax({
                url: '/api/user/booking',
                type: 'POST',
                data: data,
                success: function(response) {
                    let data    =   response.data;
                    $.notify('Столик забронирован!', 'success');
                    $("#phone").val('');
                    $("#name").val('');
                    $("#time").val('');
                    $(".close-booking").click();
                    status = true;
                },
                error: function(data) {
                    $.notify('Произошла ошибка', 'error');
                    console.log(data);
                    status = true;
                }
            });
        }

    });

    function phoneCheck() {
        if ($("#phone").val().trim() !== '') {
            $.ajax({
                url: '/api/user/phone/'+$("#phone").val(),
                type: 'GET',
                success: function(response){
                    let data    =   response.data;
                    $("#name").val(data.name);
                },
                error: function(data) {
                    $("#name").val('');
                }
            });
        }
    }

    $("#phone").mask('79999999999');
    $("#time").mask('99:99');
    $("#datepicker, #date").datepicker({
        dateFormat: 'yy-mm-dd',
        monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        dayNames: [ "Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота" ],
        dayNamesMin: [ "Вн", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
    });
</script>
<script type="text/javascript">
    $(document).ajaxStart(function() { Pace.restart(); });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    {{-- Enable deep link to tab --}}
    var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
    location.hash && activeTab && activeTab.tab('show');
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        location.hash = e.target.hash.replace("#tab_", "#");
    });
</script>
