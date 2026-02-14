<div id="analytics-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <!-- Google Analytics API Integration -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-violet-50 to-purple-50">
                <h3 class="text-lg font-semibold text-gray-900">Google Analytics API Integration</h3>
                <p class="text-sm text-gray-600 mt-1">Connect to Google Analytics API for dashboard statistics</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Setup Instructions -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="font-semibold text-blue-900 mb-2">Setup Instructions:</h4>
                    <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                        <li>Create a project in <a href="https://console.cloud.google.com" target="_blank" class="underline">Google Cloud Console</a></li>
                        <li>Enable Google Analytics Data API (GA4)</li>
                        <li>Create Service Account and download JSON credentials</li>
                        <li>Add service account email to GA4 property with Viewer role</li>
                        <li>Copy Property ID from GA4 Admin → Property Settings</li>
                    </ol>
                </div>

                <!-- GA Property ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Google Analytics Property ID
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ga_property_id" 
                        value="{{ $getSetting('analytics', 'ga_property_id') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                        placeholder="123456789">
                    <p class="mt-1 text-xs text-gray-500">Format: 9-digit number (e.g., 123456789). Find in GA4 Admin → Property Settings</p>
                </div>

                <!-- Service Account Credentials JSON -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Service Account Credentials (JSON)
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="ga_credentials_json" rows="12"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-xs"
                        placeholder='{"type": "service_account", "project_id": "...", "private_key": "...", "client_email": "..."}'
                    >{{ $getSetting('analytics', 'ga_credentials_json') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Paste entire JSON content from downloaded credentials file</p>
                    
                    @if($getSetting('analytics', 'ga_credentials_json'))
                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-green-800 font-medium">Credentials configured</span>
                        </div>
                        <form method="POST" action="{{ route('admin.settings.analytics.delete-credentials') }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete analytics credentials?')"
                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                Delete Credentials
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Test Connection Button -->
                @if($getSetting('analytics', 'ga_property_id') && $getSetting('analytics', 'ga_credentials_json'))
                <div>
                    <button type="button" 
                        onclick="testAnalyticsConnection()"
                        class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        Test Connection
                    </button>
                    <div id="test-result" class="mt-3"></div>
                </div>
                @endif
            </div>
        </div>

        <!-- Basic Analytics Tracking -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50">
                <h3 class="text-lg font-semibold text-gray-900">Analytics Tracking IDs</h3>
                <p class="text-sm text-gray-600 mt-1">Configure tracking scripts for your website</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Google Analytics ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics Tracking ID (GA4)</label>
                    <input type="text" name="settings[google_analytics_id]" 
                        value="{{ $getSetting('analytics', 'google_analytics_id') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                        placeholder="G-XXXXXXXXXX">
                    <p class="mt-1 text-xs text-gray-500">Format: G-XXXXXXXXXX (for frontend tracking script)</p>
                </div>

                <!-- Google Tag Manager ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Google Tag Manager ID</label>
                    <input type="text" name="settings[google_tag_manager_id]" 
                        value="{{ $getSetting('analytics', 'google_tag_manager_id') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                        placeholder="GTM-XXXXXXX">
                    <p class="mt-1 text-xs text-gray-500">Format: GTM-XXXXXXX</p>
                </div>

                <!-- Facebook Pixel ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Facebook Pixel ID</label>
                    <input type="text" name="settings[facebook_pixel_id]" 
                        value="{{ $getSetting('analytics', 'facebook_pixel_id') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                        placeholder="123456789012345">
                    <p class="mt-1 text-xs text-gray-500">15-16 digit number for Facebook tracking</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save Analytics Settings
            </button>
        </div>
    </form>
</div>

<script>
function testAnalyticsConnection() {
    const resultDiv = document.getElementById('test-result');
    resultDiv.innerHTML = `
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-blue-800 font-medium">Testing connection...</span>
            </div>
        </div>
    `;

    fetch('{{ route('admin.settings.analytics.test') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-green-900">${data.message}</p>
                            ${data.data ? `
                                <div class="mt-2 text-xs text-green-800 space-y-1">
                                    <p><strong>Property ID:</strong> ${data.data.property_id}</p>
                                    <p><strong>Service Account:</strong> ${data.data.service_account}</p>
                                    <p><strong>Visitors (7 days):</strong> ${data.data.visitors_7_days}</p>
                                    <p><strong>Page Views (7 days):</strong> ${data.data.page_views_7_days}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-red-900">${data.message}</p>
                            ${data.suggestions && data.suggestions.length > 0 ? `
                                <div class="mt-2 text-xs text-red-800">
                                    <p class="font-medium mb-1">Suggestions:</p>
                                    <ul class="list-disc list-inside space-y-0.5">
                                        ${data.suggestions.map(s => `<li>${s}</li>`).join('')}
                                    </ul>
                                </div>
                            ` : ''}
                            ${data.property_id ? `
                                <p class="mt-2 text-xs text-red-700"><strong>Property ID:</strong> ${data.property_id}</p>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `
            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-red-800 font-medium">Connection failed: ${error.message}</span>
                </div>
            </div>
        `;
    });
}
</script>
