<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div
      class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0"
    >
      <!-- left side -->
      <div class="flex flex-col justify-center p-8 md:p-14">
        <span class="mb-3 text-4xl font-bold">Welcome back</span>
        <span class="font-light text-gray-400 mb-8">
          Welcome back! Please enter your details
        </span>

        @if ($errors->any())
          <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
            <ul class="mb-0 list-disc list-inside">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
          @csrf

          <div class="py-4">
            <label for="email" class="mb-2 text-md block">Email</label>
            <input
              type="email"
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
              name="email"
              id="email"
              value="{{ old('email') }}"
              required
              autofocus
            />
          </div>

          <div class="py-4">
            <label for="password" class="mb-2 text-md block">Password</label>
            <input
              type="password"
              name="password"
              id="password"
              class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500"
              required
            />
          </div>

          <div class="flex justify-between w-full py-4">
            <div class="mr-24">
              <input type="checkbox" name="remember" id="remember" class="mr-2" />
              <label for="remember" class="text-md">Remember for 30 days</label>
            </div>
            <span class="font-bold text-md cursor-pointer">Forgot password</span>
          </div>

          <button
            type="submit"
            class="w-full bg-black text-white p-2 rounded-lg mb-6 hover:bg-white hover:text-black hover:border hover:border-gray-300"
          >
            Sign in
          </button>
        </form>

        <div class="text-center text-gray-400">
          Don't have an account?
           <a href="{{ route('register') }}" class="font-bold text-black">Register</a>
        </div>
      </div>

      <!-- right side -->
      <div class="relative">
        <img src="{{ asset('images/image.jpg') }}" alt="img" class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover" />
        <div
          class="absolute hidden bottom-10 right-6 p-6 bg-white bg-opacity-30 backdrop-blur-sm rounded drop-shadow-lg md:block"
        >
          <span class="text-white text-xl"
            >We've been using Untitled to kick-start every new project
            and can't <br />imagine working without it."
          </span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>