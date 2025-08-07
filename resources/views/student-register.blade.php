<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Career Day Student Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .input {
            @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200;
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-cover bg-center bg-no-repeat min-h-screen flex items-center justify-center" style="background-image: url('/images/bg-career.jpg');">

    <div class="w-full max-w-3xl bg-white bg-opacity-95 shadow-xl rounded-xl p-10 fade-in">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-950">🎓 Career Day Registration</h1>
            <p class="text-gray-500 mt-2">Fill in your details below to register for the event</p>
        </div>

        @if(session('success'))
        <!-- Modal Background -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <!-- Modal Box -->
           <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center fade-in-modal">
                <h2 class="text-2xl font-bold text-green-600 mb-4">🎉 Registration Successful!</h2>
                <p class="text-gray-700 mb-6">
                    Thank you, <span class="font-semibold text-blue-700">{{ session('student_name') }}</span>, for registering for Career Day.
                </p>

                <a href="https://www.meadowlandsbaptist.co.za"
                class="inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Back To Home
                </a>
            </div>
        </div>
        @endif


        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required class="mt-1 input" />
                </div>
                <div>
                    <label for="surname" class="block text-sm font-semibold text-gray-700">Surname</label>
                    <input type="text" name="surname" id="surname" required class="mt-1 input" />
                </div>
                <div>
                    <label for="grade" class="block text-sm font-semibold text-gray-700">Grade</label>
                    <input type="text" name="grade" id="grade" required class="mt-1 input" />
                </div>
                <div>
                    <label for="studentnum" class="block text-sm font-semibold text-gray-700">Student Number</label>
                    <input type="text" name="studentnum" id="studentnum" required class="mt-1 input" />
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="mt-1 input" />
                </div>
                <div>
                    <label for="id_number" class="block text-sm font-semibold text-gray-700">ID Number</label>
                    <input type="text" name="id_number" id="id_number" class="mt-1 input" />
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 input" />
                </div>
                <div>
                    <label for="school_id" class="block text-sm font-semibold text-gray-700">School</label>
                    <select name="school_id" id="school_id" required class="mt-1 input">
                        <option value="">-- Select School --</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="day_industry_id" class="block text-sm font-semibold text-gray-700">Event & Industry</label>
                    <select name="day_industry_id" id="day_industry_id" required class="mt-1 input">
                        <option value="">-- Select Day + Industry --</option>
                        @foreach($dayIndustries as $di)
                            <option value="{{ $di->id }}">
                                {{ $di->day->name }} - {{ $di->industry->name }} ({{ $di->day->event->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200">
                    Register Now
                </button>
            </div>
        </form>
    </div>
</body>
</html>
