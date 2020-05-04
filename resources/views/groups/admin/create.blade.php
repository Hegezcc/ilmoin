@extends('layouts.master')

@section('title', 'Create group')

@section('content')
    <form class="card" action="{{ route('admin.groups.store') }}" method="post">
        @csrf
        <div class="flex">
            <div>
                <div class="md:flex md:justify-between">
                    <div class="font-bold text-2xl mb-2">
                        Create group
                    </div>
                </div>
            </div>
        </div>

        <x-forms.field element="div" title="Organization" description="The organization to create this group in" class="mt-4">
            <select class="form-select w-full" name="organization_id" required>
                @foreach($organizations as $organization)
                    <option value="{{ $organization->id }}" {{ old('organization_id', Request::input('organization')) == $organization->id ? 'selected' : '' }}>
                        {{ $organization->name }} (ID {{ $organization->id }})
                    </option>
                @endforeach
            </select>
        </x-forms.field>

        <x-forms.field title="Name" description="The name of the group" class="mt-4">
            <x-forms.input-text name="name" :value="old('name')"/>
        </x-forms.field>

        <x-forms.field title="Description" description="Ths" class="mt-4">
            <x-forms.input-textarea name="description" :value="old('description')"/>
        </x-forms.field>

        <x-forms.field element="div" title="Is public" description="If enabled, this group will be visible to everyone." class="mt-4">
            <x-forms.yes-no-buttons name="is_public" :value="old('is_public')" />
        </x-forms.field>

        <x-forms.field element="div" title="Is member list public" description="If enabled, anyone can see the full member list of this group." class="mt-4">
            <x-forms.yes-no-buttons name="is_member_list_public" :value="old('is_member_list_public')" />
        </x-forms.field>

        <x-forms.field element="div" title="Is member list shown to other members" description="If enabled, any member can see the full member list of this group." class="mt-4">
            <x-forms.yes-no-buttons name="is_member_list_shown_to_other_members" :value="old('is_member_list_shown_to_other_members')" />
        </x-forms.field>

        <x-forms.field element="div" title="Save" description="Creates the group in the database." class="mt-4">
            <button type="submit" class="button-pink">Save</button>
        </x-forms.field>
    </form>
@endsection
