    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Tel</th>
            <th>Nationality</th>
            {{-- <th>Role</th> --}}
            <th>Registred</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
                @if($users)
                    @foreach($users as $user)
                        <tr id="event{{ $user->user_id }}" class="inactive">
                            <td>
                            <?php
                                                                                    if($user->gender == 1 OR $user->gender == 0){ $gender = 'male'; }elseif($user->gender == 2){ $gender = 'female'; }
                                                                            ?>
                            <img src="@if($user->image == '') /uploads/default_avatar_{{ $gender }}.jpg @else /storage/uploads/users/profile/{{ $user->image }}.jpg @endif" style="max-width:35px;border:1px #a97f18 solid;box-shadow: 0 2px 14px 0 rgba(0,0,0,0.1)">&ensp;{{ $user->user_title['title'].' '.$user->first_name.' '.$user->last_name }}</td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                    {{ $user->phone ? null: 'N/A' }}
                            </td>
                            <td>
                                    @if($user->countries['name'] == 'HOST' OR $user->countries['name'] == NULL) {{ 'N/A' }} @else {{ $user->countries['name'] }} @endif
                            </td>
                            {{-- <td>
                                    {{$user->user_type['description']}}
                            </td> --}}
                            <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ url('admin/all-users/profile/'.$user->user_id) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                <td>
                {{ 'No Users' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            @endif
    </tbody>
