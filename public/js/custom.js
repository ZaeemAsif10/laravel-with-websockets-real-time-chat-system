

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {

    $('.user-list').on('click', function () {

        $('#chat-container').html('');

        //get chat user id and store in global variable receiver_id
        var getUserId = $(this).attr('data-id');
        receiver_id = getUserId;

        $('.start-head').hide();
        $('.chat-section').show();

        // load old chats
        loadOldChats();

    });


    //save chat work
    $('#chat-form').submit(function (e) {
        e.preventDefault();

        var message = $('#message').val();

        $.ajax({
            url: "/save-chat",
            type: "POST",
            data: {
                sender_id: sender_id,
                receiver_id: receiver_id,
                message: message,
            },
            success: function (res) {
                if (res.success) {

                    $('#message').val('');

                    let chat = res.data.message;

                    let html = `<div class="current-user-chat" id='` + res.data.id + `-chat'>
                    <div class="container-message send">
                        <img src="/w3images/bandmember.jpg" alt="Avatar" style="width:100%;">
                        <p>`+ chat + `</p>
                        <span class="time-right">11:00</span>
                        <span class="del_message" data-id="`+ res.data.id + `" data-toggle="modal" data-target="#deleteChatModal">Delete</span>
                        <span class="upate_message" data-id="`+ res.data.id + `" data-msg='` + res.data.message + `' data-toggle="modal" data-target="#updateChatModal">Update</span>
                    </div>
                </div>`;

                    $('#chat-container').append(html);
                    scrollChat();

                } else {
                    alert(res.msg);
                }
            }
        });

    });


    $(document).on('click', '.del_message', function () {

        var id = $(this).attr('data-id');
        $('#delete-chat-id').val(id);
        $('#delete-message').text($(this).parent().find('p').text());
    });

    //ajax call for delete chat
    $('#delete-chat-form').submit(function (e) {
        e.preventDefault();

        var id = $('#delete-chat-id').val();

        $.ajax({
            url: "/delete-chat",
            type: "POST",
            data: { id: id },
            success: function (res) {
                // alert(res.msg);
                if (res.success) {
                    $('#' + id + '-chat').remove();
                    $('#deleteChatModal').modal('hide');
                }
            }
        });

    });

    //Edit chat message
    $(document).on('click', '.upate_message', function () {

        $('#update-chat-id').val($(this).attr('data-id'));
        $('#update-message').val($(this).attr('data-msg'));

    });

    //  ajax call for edit or update chat messages
    $('#update-chat-form').submit(function (e) {
        e.preventDefault();

        var id = $('#update-chat-id').val();
        var msg = $('#update-message').val();

        $.ajax({
            url: "/update-chat",
            type: "POST",
            data: { id: id, message: msg },
            success: function (res) {
                // alert(res.msg);
                if (res.success) {
                    $('#updateChatModal').modal('hide');
                    $('#' + id + '-chat').find('p').text(msg);
                    $('#' + id + '-chat').find('.upate_message').attr('data-msg', msg);
                } else {
                    alert(res.msg);
                }
            }
        });

    });


    //Group Section Start

    //ajax call for create groups
    $('#creatGroupForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "/create-group",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                alert(res.msg);
                console.log(res.msg);
                if (res.success) {
                    location.reload();
                }
            }
        });

    });

    //Group Section End

}); //document.ready end

// load old chat ajax function
function loadOldChats() {

    $.ajax({
        url: "/load-chats",
        type: "POST",
        data: {
            sender_id: sender_id,
            receiver_id: receiver_id
        },
        success: function (res) {
            if (res.success) {

                $('#message').val('');

                let chats = res.data;
                let html = '';

                for (let i = 0; i < chats.length; i++) {
                    let addClass = '';
                    if (chats[i].sender_id == sender_id) {
                        addClass = 'current-user-chat';
                        colorClass = 'send';
                    } else {
                        addClass = 'distance-user-chat';
                        colorClass = 'reveive';
                    }

                    html += `<div class="` + addClass + `" id="` + chats[i].id + `-chat">
                    <div class="container-message `+ colorClass + `">
                        <img src="/w3images/bandmember.jpg" alt="Avatar" style="width:100%;">
                        <p>`+ chats[i].message + `</p>
                        <span class="time-right">11:00</span>`;
                    if (chats[i].sender_id == sender_id) {

                        html += `<span class="del_message" data-id="` + chats[i].id + `" data-toggle="modal" data-target="#deleteChatModal">Delete</span>
                        <span class="upate_message" data-id="`+ chats[i].id + `" data-msg='` + chats[i].message + `' data-toggle="modal" data-target="#updateChatModal">Update</span>`

                    }
                    html += `</div>
                </div>`;
                }

                $('#chat-container').append(html);
                scrollChat();

            } else {
                alert(res.msg);
            }
        }
    });

}

//function for scroll chat
function scrollChat() {
    $('#chat-container').animate({
        scrollTop: $('#chat-container').offset().top + $('#chat-container')[0].scrollHeight
    }, 0);

}



Echo.join('status-update')
    .here((users) => {

        for (let x = 0; x < users.length; x++) {
            if (sender_id != users[x]['id']) {
                $('#' + users[x]['id'] + '-status').removeClass('offline-status');
                $('#' + users[x]['id'] + '-status').addClass('online-status');
                $('#' + users[x]['id'] + '-status').text('Online');
            }
        }

    }).joining((user) => {
        $('#' + user.id + '-status').removeClass('offline-status');
        $('#' + user.id + '-status').addClass('online-status');
        $('#' + user.id + '-status').text('Online');
    })
    .leaving((user) => {
        $('#' + user.id + '-status').addClass('offline-status');
        $('#' + user.id + '-status').removeClass('online-status');
        $('#' + user.id + '-status').text('Offline');
    })
    .listen('UserStatusEvent', (e) => {
        // console.log(e);
    });

Echo.private('broadcast-message')
    .listen('.getChatMessage', (data) => {

        if (sender_id == data.chat.receiver_id && receiver_id == data.chat.sender_id) {
            let html = `<div class="distance-user-chat" id="` + data.chat.id + `-chat">
            <div class="container-message reveive">
                <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right"
                    style="width:100%;">
                <p>`+ data.chat.message + `</p>
                <span class="time-left">11:01</span>
            </div>
        </div>`;

            $('#chat-container').append(html);
            scrollChat();
        }

    });

//Delete message Event listen
Echo.private('message-deleted')
    .listen('MessageDeletedEvent', (data) => {
        $('#' + data.id + '-chat').remove();
    });

//Update message Event listen
Echo.private('message-updated')
    .listen('MessageUpdateEvent', (data) => {
        $('#' + data.data.id + '-chat').find('p').text(data.data.message);
    });
