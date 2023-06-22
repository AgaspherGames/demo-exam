@extends('layout')
@section('content')

<div class="relative overflow-x-auto">
    <h2 class="my-4 text-xl font-semibold">Users</h2>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Thumbnail
                </th>
                <th scope="col" class="px-6 py-3">
                    Author
                </th>
                <th scope="col" class="px-6 py-3">
                    Versions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
            <tr class="{{$game->deleted_at?'bg-red-100':'bg-white'}} border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    <a href="{{route('game', $game->slug)}}">
                        {{$game->title}}
                    </a>
                </th>
                <td class="px-6 py-4">
                    {{$game->description}}
                </td>
                <td class="px-6 py-4">
                    <img src="{{$game->thumbnail}}" alt="">
                </td>
                <td class="px-6 py-4">
                    {{$game->user->username}}
                </td>
                <td class="px-6 py-4">
                    @foreach($game->versions as $version)
                    <p>{{$version->version}}</p> <br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection