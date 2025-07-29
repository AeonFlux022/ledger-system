<form method="POST" action="/borrowers" enctype="multipart/form-data">
    @csrf
    <div class="mb-4 flex space-x-4">
        <div class="w-1/2">
            <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" id="fname" name="fname"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="w-1/2">
            <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" id="lname" name="lname"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    <div class="mb-4 flex space-x-4">
        <div class="w-1/2">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" id="address" name="address"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="w-1/4">
            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="w-1/4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" id="email" name="email"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    <div class="mb-4 flex space-x-4">
        <div class="w-1/2">
            <label for="id_card" class="block text-sm font-medium text-gray-700">Identification
                Card</label>
            <select name="id_card" class="mt-1 block w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm"
                required>
                <option value="" disabled selected>Select ID Type</option>
                <option value="national_id">National ID</option>
                <option value="drivers_license">Driver's License</option>
                <option value="sss_id">SSS ID</option>
                <option value="prc_id">PRC ID</option>
                <option value="umid">UMID</option>
                <option value="philhealth_id">PhilHealth ID</option>
                <option value="passport">Passport</option>
            </select>
        </div>
        <div class="w-1/2">
            {{-- upload image here --}}
            <div>
                <label for="id_image" class="block text-sm font-medium text-gray-700">Upload ID Image</label>
                <input type="file" name="id_image" id="id_image" accept="image/*"
                    class="mt-1 block w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm bg-white text-gray-700">
            </div>
        </div>
    </div>
    <div class="mb-4 flex space-x-4">
        <div class="w-1/2">
            <label for="income" class="block text-sm font-medium text-gray-700">Income</label>
            <input type="number" id="income" name="income"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4 w-1/2">
            <label for="employment_status" class="block text-sm font-medium text-gray-700">Employment Status</label>
            <select name="employment_status" id="employment_status"
                class="mt-1 block w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm" required>
                <option value="" disabled selected>Select status</option>
                <option value="employed">Employed</option>
                <option value="unemployed">Unemployed</option>
            </select>
        </div>
    </div>
    <div class="flex justify-end space-x-2">
        <button type="button" class="px-4 py-2 border rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
    </div>

</form>
