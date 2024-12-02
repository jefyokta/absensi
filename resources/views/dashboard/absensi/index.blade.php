@extends('dashboard.layouts.main')

@section('container')
    <div class="">
        <div class="">
            <div class="card">
                <h5 class="card-header p-3 font-semibold text-4xl"> Absen</h5>
                <div class="card-body">
                    <form class=" mx-auto glass p-5 w-8/12 rounded-lg" action="/dashboard/absensi" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <label for="countries"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan</label>
                        <select id="countries"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="why">
                            <option value="sakit">Sakit</option>
                            <option value="cuti">Cuti</option>
                        </select>

                        <label for="message"
                            class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Detail</label>
                        <textarea id="message" rows="4" name="reason"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Jelaskan Alasan mu disini"></textarea>

                        <p class="px-2 py-2">Bukti</p>
                        <div class="flex flex-col items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex relative flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p id="file-name" class="text-xs text-gray-500 dark:text-gray-400"></p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" name="image" accept="image/*" />
                                <img id="preview-image" src="" alt="Image Preview"
                                    class="hidden w-full h-full absolute object-cover rounded-lg border-2 border-gray-300" />
                            </label>
                            <div class="mt-4">
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-500 p-2 text-sm text-white rounded-md">Kirim</button>
                    </form>
                </div>
            </div>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('dropzone-file');
                const previewImage = document.getElementById('preview-image');
                const fileNameDisplay = document.getElementById('file-name');

                fileInput.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('hidden');
                            fileNameDisplay.textContent = file.name;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                function updateTime() {
                    const now = new Date();
                    document.getElementById("time").textContent = now.toLocaleTimeString();
                }

                setInterval(updateTime, 1000); 
            });
        </script>
    </div>
@endsection
