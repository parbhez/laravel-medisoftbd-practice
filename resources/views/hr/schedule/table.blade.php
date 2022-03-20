<table id="doctorDatatable" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Date</th>
        <th>Day</th>
        <th>Doctor Name</th>
        <th>Schedule</th>
    </tr>
    </thead>
    <tbody>

    @if(count($allschedulesdata) > 0)
        @foreach($allschedulesdata as $key => $schedule)
            <tr>
                <td>{{$schedule['date']}}</td>
                <td>{{$schedule['schedule_obj']->schedule_date}}</td>
                <td>{{$schedule['schedule_obj']->user->full_name}}</td>
                <td>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Visitor Limit</th>
                            <th>Blocked</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($schedule['schedule_obj']->scheduleslots as $key => $slot)
                            <tr>
                                <td>{{$slot->start_time}}</td>
                                <td>{{$slot->end_time}}</td>
                                <td>{{$slot->visitor_limit}}</td>
                                <td>
                                    @if($slot->block)
                                        @if($slot->block->isBlock($slot->schedule_slot_id, $schedule['date'])===true)

                                            <input type="checkbox"
                                                   onchange="changeAppointmentStatus(this,'{{$schedule['date']}}','{{$slot->schedule_slot_id}}');"
                                                   class="appointment_status_toggle"
                                                   value="0"
                                                   data-onstyle="danger"
                                                   data-offstyle="info" checked
                                                   data-toggle="toggle" data-size="mini">

                                        @else
                                            <input type="checkbox" class="appointment_status_toggle"
                                                   onchange="changeAppointmentStatus(this,'{{$schedule['date']}}','{{$slot->schedule_slot_id}}');"
                                                   value="1"
                                                   data-onstyle="danger"
                                                   data-offstyle="info"
                                                   data-toggle="toggle" data-size="mini">
                                        @endif
                                    @else
                                        <input type="checkbox" class="appointment_status_toggle"
                                               onchange="changeAppointmentStatus(this,'{{$schedule['date']}}','{{$slot->schedule_slot_id}}');"
                                               value="1"
                                               data-onstyle="danger"
                                               data-offstyle="info"
                                               data-toggle="toggle" data-size="mini">
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>

                </td>
            </tr>

        @endforeach
    @endif

    </tbody>
    <tfoot>
    <tr>
        <th>Date</th>
        <th>Day</th>
        <th>Doctor Name</th>
        <th>Schedule</th>
    </tr>
    </tfoot>

</table>

<script>
    $(function () {
        $('.appointment_status_toggle').bootstrapToggle();
    })
</script>

<script>
    function changeAppointmentStatus(ele, blockDate, scheduleSlotId) {
        var statusType;
        if (ele.checked === true) {
            statusType = 0;
        } else {
            statusType = 1;
        }
        $.ajax({
            url: "update-schedule",
            method: "GET",
            dataType: "json",
            data: {
                schedule_slot_id: scheduleSlotId,
                schedule_block_date: blockDate,
                type: statusType
            },
            success: function (data) {
                if (data.success == true) {
                    $('.box-modal-message').show();
                    $('.messageBodySuccess').slideDown(1000).delay(3000).slideUp(1000).children().next()
                        .html(data.message);
                } else {
                    $('.box-modal-message').show();
                    $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next()
                        .html(data.message);
                }
            },
            error: function (data) {
                $('.box-modal-message').show();
                $('.messageBodyError').slideDown(1000).delay(3000).slideUp(1000).children().next().html(
                    data.message);
            }
        });
    }

</script>
