<div id="about-tab" class="tab-content">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-lg font-semibold text-gray-900">About Statistics</h3>
                <p class="text-sm text-gray-600 mt-1">Configure statistics displayed on About page</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">About Statistics Information:</p>
                            <p>Statistik ini akan ditampilkan di halaman About untuk menunjukkan pencapaian atau data penting perusahaan Anda. Contoh: jumlah user, transaksi, rating, dll.</p>
                        </div>
                    </div>
                </div>

                <!-- Statistic 1 -->
                <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-lg text-sm font-bold">1</span>
                        Statistic 1
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number / Value</label>
                            <input type="text" name="settings[about_stat_1_number]" 
                                value="{{ $getSetting('about', 'about_stat_1_number') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., 10K+, 99%, 24/7">
                            <p class="mt-1 text-xs text-gray-500">Angka atau nilai yang ingin ditampilkan</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label / Description</label>
                            <input type="text" name="settings[about_stat_1_label]" 
                                value="{{ $getSetting('about', 'about_stat_1_label') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Active Users, Customer Satisfaction">
                            <p class="mt-1 text-xs text-gray-500">Deskripsi atau label untuk statistik</p>
                        </div>
                    </div>
                </div>

                <!-- Statistic 2 -->
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-lg text-sm font-bold">2</span>
                        Statistic 2
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number / Value</label>
                            <input type="text" name="settings[about_stat_2_number]" 
                                value="{{ $getSetting('about', 'about_stat_2_number') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., 500+, 95%, 1M+">
                            <p class="mt-1 text-xs text-gray-500">Angka atau nilai yang ingin ditampilkan</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label / Description</label>
                            <input type="text" name="settings[about_stat_2_label]" 
                                value="{{ $getSetting('about', 'about_stat_2_label') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Projects Completed, Monthly Transactions">
                            <p class="mt-1 text-xs text-gray-500">Deskripsi atau label untuk statistik</p>
                        </div>
                    </div>
                </div>

                <!-- Statistic 3 -->
                <div class="p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border-2 border-purple-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-purple-600 text-white rounded-lg text-sm font-bold">3</span>
                        Statistic 3
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number / Value</label>
                            <input type="text" name="settings[about_stat_3_number]" 
                                value="{{ $getSetting('about', 'about_stat_3_number') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., 99%, 4.9/5, 100+">
                            <p class="mt-1 text-xs text-gray-500">Angka atau nilai yang ingin ditampilkan</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label / Description</label>
                            <input type="text" name="settings[about_stat_3_label]" 
                                value="{{ $getSetting('about', 'about_stat_3_label') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Customer Satisfaction, Average Rating">
                            <p class="mt-1 text-xs text-gray-500">Deskripsi atau label untuk statistik</p>
                        </div>
                    </div>
                </div>

                <!-- Statistic 4 -->
                <div class="p-6 bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl border-2 border-orange-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-orange-600 text-white rounded-lg text-sm font-bold">4</span>
                        Statistic 4
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number / Value</label>
                            <input type="text" name="settings[about_stat_4_number]" 
                                value="{{ $getSetting('about', 'about_stat_4_number') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., 24/7, 50+, 100%">
                            <p class="mt-1 text-xs text-gray-500">Angka atau nilai yang ingin ditampilkan</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label / Description</label>
                            <input type="text" name="settings[about_stat_4_label]" 
                                value="{{ $getSetting('about', 'about_stat_4_label') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Support Available, Countries Served">
                            <p class="mt-1 text-xs text-gray-500">Deskripsi atau label untuk statistik</p>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview (How it looks on About page)
                    </h4>
                    <div class="bg-white rounded-lg p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <p class="text-3xl font-extrabold text-blue-600 mb-1">
                                {{ $getSetting('about', 'about_stat_1_number') ?: '10K+' }}
                            </p>
                            <p class="text-sm font-medium text-gray-600">
                                {{ $getSetting('about', 'about_stat_1_label') ?: 'Active Users' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-extrabold text-green-600 mb-1">
                                {{ $getSetting('about', 'about_stat_2_number') ?: '500+' }}
                            </p>
                            <p class="text-sm font-medium text-gray-600">
                                {{ $getSetting('about', 'about_stat_2_label') ?: 'Projects Completed' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-extrabold text-purple-600 mb-1">
                                {{ $getSetting('about', 'about_stat_3_number') ?: '99%' }}
                            </p>
                            <p class="text-sm font-medium text-gray-600">
                                {{ $getSetting('about', 'about_stat_3_label') ?: 'Customer Satisfaction' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-extrabold text-orange-600 mb-1">
                                {{ $getSetting('about', 'about_stat_4_number') ?: '24/7' }}
                            </p>
                            <p class="text-sm font-medium text-gray-600">
                                {{ $getSetting('about', 'about_stat_4_label') ?: 'Support Available' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Save About Statistics
            </button>
        </div>
    </form>
</div>
