<x-layout title="Admin Dashboard">
    <x-partials.admin.nav :name="auth()->user()->full_name"/>
</x-layout>