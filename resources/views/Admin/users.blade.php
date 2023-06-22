@extends('layout')
@section('content')

<div class="relative overflow-x-auto">
    <h2 class="my-4 text-xl font-semibold">Users</h2>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Login
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="{{$user->ban_reason?'bg-red-100':'bg-white'}} border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    <a href="{{route('user', $user->username)}}">
                        {{$user->username}}
                    </a>
                </th>
                <td class="px-6 py-4">
                    {{$user->created_at}}
                </td>
                <td class="px-6 py-4">
                    {{$user->last_login}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection