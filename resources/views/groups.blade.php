<x-app-layout>



    <div class="container mt-4">
        <h1 style="font-size: 30px;">Groups</h1>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createGroupModal">
            Create Groups
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Limit</th>
                    <th>Member</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($groups) > 0)
                    @foreach ($groups as $key => $group)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{ $group->image }}" class="img-fluid" width="50px" height="50px"
                                    alt="{{ $group->name }}"></td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->join_limit }}</td>
                                    <td><a href="#">Members</a></td>
                                    <td></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="6">No Group Found!</th>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" enctype="multipart/form-data" id="creatGroupForm">
                        <div class="modal-body">
                            <input type="text" name="name" class="form-control mb-3"
                                placeholder="Enter Group Name" required>
                            <input type="file" name="image" class="form-control mb-3" required>
                            <input type="number" name="join_limit" class="form-control mb-3"
                                placeholder="Enter User Limit" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Group</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
