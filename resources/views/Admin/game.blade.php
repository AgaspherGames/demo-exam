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
            <tr class="{{$game->deleted_at?'bg-red-100':'bg-white'}} border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    <a href="{{route('user', $game->title)}}">
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
        </tbody>
    </table>
    <div class="border my-4 p-4">
        <h2 class="my-4 text-xl font-semibold">Scores</h2>
        <form action="{{route('game.clear', $game->slug)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class=" mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">DELETE SCORES</button>
        </form>
        @foreach($game->versions as $version)
        <h4 class="text-lg font-semibold my-4">{{$version->version}}</h4>
        @foreach($version->scores as $score)
        <div class="flex items-center justify-between">
            <details>
                <summary>
                    <span> {{$score->user->username}} - {{$score->score}}</span>
                </summary>
                <div>
                    <form action="{{route('game.clearUserScore', [$game->slug, $score->user_id])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class=" mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">DELETE SCORE</button>
                    </form>
                </div>
            </details>
            <form action="{{route('game.clearScore', $score->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class=" mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">DELETE SCORE</button>
            </form>
        </div>
        @endforeach
        @endforeach
    </div>
    <div class="border my-4 p-4">
        <form action="{{route('game.delete', $game->slug)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class=" mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">DELETE GAME</button>
        </form>
    </div>
</div>

@endsection