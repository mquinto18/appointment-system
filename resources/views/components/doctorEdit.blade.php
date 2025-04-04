@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('contents')

<div>
    <h1 class='font-medium text-2xl ml-3'>Edit Doctor</h1>
</div>
<div class='w-full h-32 mt-5 rounded-lg' style="background: linear-gradient(to bottom, #0074C8, #151A5C);"></div>

<div class='mx-10 -m-16'>
    <div class='flex justify-between mb-2'>
        <span class='text-[20px] text-white font-medium'>Update Doctor</span>
    </div>

    <div class='bg-white w-full rounded-lg shadow-md p-8'>
        <form method="POST" action="{{ route('doctor.update', $doctor->id) }}">
            @csrf
            @method('PUT') <!-- Laravel's method spoofing for PUT request -->

            <div class='mb-7'>
                <h1 class='text-[#0074C8] font-medium text-[20px]'>Doctor details</h1>
            </div>

            <div class='grid grid-cols-3 gap-4'>
                <!-- Admin Name -->
                <div class="">
                    <label for="adminNameEdit" class="form-label">Name</label>
                    <input type="text" class="form-control" id="adminNameEdit" name="name" value="{{  $doctor->name }}" required>
                </div>

                <!-- Admin Email -->
                <div class="">
                    <label for="adminEmailEdit" class="form-label">Email</label>
                    <input type="email" class="form-control" id="adminEmailEdit" name="email" value="{{  $doctor->email }}" required>
                </div>

                <!-- Admin Phone Number -->
                <div class="">
                    <label for="adminPhoneEdit" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="adminPhoneEdit" name="phone_number" value="{{  $doctor->phone_number }}">
                </div>

                <!-- Date of Birth -->
                <div class="">
                    <label for="adminDOBEdit" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="adminDOBEdit" name="date_of_birth" value="{{  $doctor->date_of_birth }}">
                </div>

                <!-- Admin Gender -->
                <div class="">
                    <label for="adminGenderEdit" class="form-label">Gender</label>
                    <select class="form-select" id="adminGenderEdit" name="gender">
                        <option value="male" {{  $doctor->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{  $doctor->gender == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{  $doctor->gender == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Admin Address -->
                <div class="">
                    <label for="adminAddressEdit" class="form-label">Address</label>
                    <textarea class="form-control" id="adminAddressEdit" name="address" rows="3">{{  $doctor->address }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class='flex gap-4'>
                        <label>
                            <input type="radio" name="status" value="active" {{ $doctor->status == 'active' ? 'checked' : '' }}>
                            <span>Active</span>
                        </label>
                        <label>
                            <input type="radio" name="status" value="inactive" {{ $doctor->status == 'inactive' ? 'checked' : '' }}>
                            <span>Inactive</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class='flex justify-end mt-5'>
                <button type="submit" class="bg-[#0074C8] text-white py-2 px-4 font-medium rounded-md">Update Doctor</button>
            </div>
        </form>
    </div>
</div>

@endsection
