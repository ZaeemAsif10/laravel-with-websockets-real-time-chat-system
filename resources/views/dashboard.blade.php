<x-app-layout>



    <div class="container mt-4">
        <div class="row">

            @if (count($users) > 0)
                <div class="col-md-4">
                    <ul class="list-group">
                        @foreach ($users as $user)
                            @php

                                if ($user->image != '' && $user->image != null) {
                                    $image = $user->image;
                                } else {
                                    $image = 'dummy-img/dummy-img.jpg';
                                }
                            @endphp
                            <li class="list-group-item list-group-item-dark cursor-pointer user-list"
                                data-id="{{ $user->id }}">
                                <img src="{{ $image ?? '' }}" class="user-image rounded-circle" alt="No Image">
                                {{ $user->name ?? 'New User' }}
                                <b><sup id="{{ $user->id }}-status" class="offline-status">Offline</sup></b>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-8">
                    <h3 class="start-head">Click to Start the Chat</h3>

                    <div class="chat-section">
                        <div id="chat-container">

                        </div>

                        <form action="" id="chat-form" class="mt-2">
                            <div class="d-flex">
                                <input type="text" name="message" class="form-control" placeholder="Enter Message"
                                    id="message" required>
                                <input type="submit" value="Send Message" class="btn btn-primary">
                            </div>
                        </form>

                    </div>

                </div>
            @else
                <div class="col-md-12">
                    <div>No User Found</div>
                </div>
            @endif

        </div>
    </div>

    <!-- Delete Chat Modal -->
    <div class="modal fade" id="deleteChatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" id="delete-chat-form">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="delete-chat-id">
                        <p>Are you sure you want to delete below message?</p>
                        <p><b id="delete-message"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Chat Modal -->
    <div class="modal fade" id="updateChatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" id="update-chat-form">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="update-chat-id">
                        <input type="text" name="message" placeholder="Enter Message" id="update-message"
                            class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
