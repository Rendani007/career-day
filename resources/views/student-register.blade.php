<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Career Day Student Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Only keep animation here; Tailwind utilities are applied directly */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-modal {
            animation: fadeIn 0.25s ease-out;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">

    {{-- Hero background (subtle, with overlay), hidden on very small devices if image is heavy --}}
    <div class="fixed inset-0 -z-10">
        <div class="h-full w-full bg-cover bg-center" style="background-image: url('/images/bg-career.jpg');"></div>
        <div class="absolute inset-0 bg-white/70 md:bg-white/60"></div>
    </div>

    <main class="w-full max-w-3xl mx-auto px-4 sm:px-6 md:px-8 py-6 sm:py-10 lg:py-12">
        <div class="w-full bg-white/95 backdrop-blur-sm shadow-xl rounded-xl p-5 sm:p-8 md:p-10 fade-in">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-blue-950">🎓 Career Day Registration</h1>
                <p class="text-gray-600 mt-2 text-sm sm:text-base">Fill in your details below to register for the event.</p>
            </div>

            {{-- Success Modal --}}
            @if(session('success'))
                <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 sm:p-8 text-center fade-in-modal">
                        <h2 class="text-xl sm:text-2xl font-bold text-green-600 mb-3">🎉 Registration Successful!</h2>
                        <p class="text-gray-700 mb-6 text-sm sm:text-base">
                            Thank you, <span class="font-semibold text-blue-700">{{ session('student_name') }}</span>, for registering for Career Day.
                        </p>
                        <a href="https://www.meadowlandsbaptist.co.za"
                           class="inline-flex items-center justify-center w-full sm:w-auto bg-blue-600 text-white font-semibold px-5 py-3 rounded-lg hover:bg-blue-700 transition">
                            Back To Home
                        </a>
                    </div>
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <ul class="list-disc pl-5 text-red-700 text-sm sm:text-base">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-gray-400"> * </span></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            autocomplete="given-name"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div>
                        <label for="surname" class="block text-sm font-medium text-gray-700">Surname <span class="text-gray-400"> * </span></label>
                        <input
                            type="text"
                            name="surname"
                            id="surname"
                            autocomplete="family-name"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700">Grade<span class="text-gray-400"> * </span></label>
                        <input
                            type="number"
                            name="grade"
                            id="grade"
                            min="8" max="12"
                            inputmode="numeric"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div>
                        <label for="studentnum" class="block text-sm font-medium text-gray-700">Student Number <span class="text-gray-400">(optional)</span></label>
                        <input
                            type="text"
                            name="studentnum"
                            id="studentnum"
                            autocomplete="off"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-gray-400"> * </span></label>
                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            inputmode="tel"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700">ID Number <span class="text-gray-400">(optional)</span></label>
                        <input
                            type="text"
                            name="id_number"
                            id="id_number"
                            autocomplete="off"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-gray-400">(optional)</span></label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="school_id" class="block text-sm font-medium text-gray-700">School <span class="text-gray-400"> * </span></label>
                        <select
                            name="school_id"
                            id="school_id"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        >
                            <option value="">-- Select School --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="day_industry_id" class="block text-sm font-medium text-gray-700">Event & Industry <span class="text-gray-400"> * </span></label>
                        <select
                            name="day_industry_id"
                            id="day_industry_id"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                        >
                            <option value="">-- Select Day + Industry --</option>
                            @foreach($dayIndustries as $di)
                                <option value="{{ $di->id }}">
                                    {{ $di->day->name }} — {{ $di->industry->name }} ({{ $di->day->event->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition"
                    >
                        Register Now
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
