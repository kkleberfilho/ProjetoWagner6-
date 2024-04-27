@extends('site.layout.layouthome')

@section('titulo', 'Home')

@section('conteudo')
    <div class="cadastro">
        <div class="cadastro_tamanho"> 
            <h1>Home Cadastro</h1>
            @if($endereco)
            <h2>Endereço:</h2>
            <p>CEP: {{ $endereco->cep }}</p>
            <p>Logradouro: {{ $endereco->logradouro }}</p>
            <p>Número: {{ $endereco->numero }}</p>
            <p>Bairro: {{ $endereco->bairro }}</p>
            <p>Município: {{ $endereco->municipio }}</p>
            <p>Estado: {{ $endereco->estado }}</p>
            <p>Complemento: {{ $endereco->complemento }}</p>
            @else
            <p>Nenhum endereço cadastrado.</p>
            @endif
        </div>
    </div>
@endsection
