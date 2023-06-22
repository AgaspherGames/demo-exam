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
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{$user->username}}
                </th>
                <td class="px-6 py-4">
                    {{$user->created_at}}
                </td>
                <td class="px-6 py-4">
                    {{$user->last_login}}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="border my-4 p-4">
        <form action="{{route('ban', $user->username)}}" method="post">
            @csrf
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900">Select ban reason</label>
            <select id="countries" name="ban_reason" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                <option value="You have been blocked by an administrator" selected>You have been blocked by an administrator</option>
                <option value="You have been blocked for spamming">You have been blocked for spamming</option>
                <option value="You have been blocked for cheating">You have been blocked for cheating</option>
            </select>

            <button type="submit" class=" mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Ban</button>
        </form>
    </div>
</div>

@endsection