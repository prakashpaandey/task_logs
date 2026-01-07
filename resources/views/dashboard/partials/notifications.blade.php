    <!-- Success Notification -->
    <div id="success-notification" class="fixed top-6 right-6 w-[calc(100%-3rem)] md:w-auto max-w-md bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-[150%] transition-transform duration-300 z-50 invisible">
        <i class="fas fa-check-circle text-xl"></i>
        <div>
            <p class="font-medium" id="success-message">Operation completed successfully!</p>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="error-notification" class="fixed top-6 right-6 w-[calc(100%-3rem)] md:w-auto max-w-md bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform translate-x-[150%] transition-transform duration-300 z-50 invisible">
        <i class="fas fa-exclamation-circle text-xl"></i>
        <div>
            <p class="font-medium" id="error-message">An error occurred. Please try again.</p>
        </div>
    </div>
