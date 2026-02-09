<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('meta_title', $settings['seo_meta_title'] ?? 'Konter Digital CMS'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', $settings['seo_meta_description'] ?? ''); ?>">
    <?php if(!empty($settings['favicon'])): ?>
        <link rel="icon" type="image/png" href="<?php echo e(asset('storage/' . $settings['favicon'])); ?>">
    <?php endif; ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php if(isset($settings['google_analytics_id']) && $settings['google_analytics_id']): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($settings['google_analytics_id']); ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo e($settings['google_analytics_id']); ?>');</script>
    <?php endif; ?>
</head>
<body class="antialiased bg-white">
    <!-- Navbar -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                        <?php if(!empty($settings['logo'])): ?>
                            <img src="<?php echo e(asset('storage/' . $settings['logo'])); ?>" alt="<?php echo e($settings['site_name'] ?? 'Logo'); ?>" class="h-10 w-auto">
                        <?php else: ?>
                            <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent"><?php echo e($settings['site_name'] ?? 'Konter Digital'); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <?php if($headerMenu && $headerMenu->items): ?>
                        <?php $__currentLoopData = $headerMenu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->is_active): ?>
                                <?php if($item->children->count() > 0): ?>
                                    <div class="relative group">
                                        <button class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors flex items-center"><?php echo e($item->title); ?><svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                            <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($child->is_active): ?>
                                                    <a href="<?php echo e($child->url); ?>" target="<?php echo e($child->target); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 first:rounded-t-lg last:rounded-b-lg"><?php echo e($child->title); ?></a>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo e($item->url); ?>" target="<?php echo e($item->target); ?>" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors"><?php echo e($item->title); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="<?php echo e(route('blog.index')); ?>" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium">Blog</a>
                    <?php endif; ?>
                    <a href="https://play.google.com/store" target="_blank" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium hover:shadow-lg transition-all duration-300">Download App</a>
                </div>
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-purple-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <?php if($headerMenu && $headerMenu->items): ?>
                    <?php $__currentLoopData = $headerMenu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item->is_active): ?>
                            <?php if($item->children->count() > 0): ?>
                                <div class="space-y-1">
                                    <button class="w-full text-left text-gray-700 hover:bg-purple-50 hover:text-purple-600 px-3 py-2 text-base font-medium rounded-md"><?php echo e($item->title); ?></button>
                                    <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($child->is_active): ?>
                                            <a href="<?php echo e($child->url); ?>" target="<?php echo e($child->target); ?>" class="block pl-6 pr-3 py-2 text-sm text-gray-600 hover:bg-purple-50 hover:text-purple-600 rounded-md"><?php echo e($child->title); ?></a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo e($item->url); ?>" target="<?php echo e($item->target); ?>" class="block text-gray-700 hover:bg-purple-50 hover:text-purple-600 px-3 py-2 text-base font-medium rounded-md"><?php echo e($item->title); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <a href="<?php echo e(route('home')); ?>" class="block text-gray-700 hover:bg-purple-50 hover:text-purple-600 px-3 py-2 text-base font-medium rounded-md">Home</a>
                    <a href="<?php echo e(route('blog.index')); ?>" class="block text-gray-700 hover:bg-purple-50 hover:text-purple-600 px-3 py-2 text-base font-medium rounded-md">Blog</a>
                <?php endif; ?>
                <a href="https://play.google.com/store" target="_blank" class="block bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-3 py-2 text-base font-medium rounded-md text-center">Download App</a>
            </div>
        </div>
    </nav>

    <?php $headerAds = \App\Models\Ad::getByPosition('header', ['page' => request()->route()->getName()]); ?>
    <?php if($headerAds->count() > 0): ?>
        <div class="pt-16">
            <?php $__currentLoopData = $headerAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4"><?php echo $ad->code; ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

<?php if(isset($homepage)): ?>
    <main class="pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-6"><?php echo e($homepage->title); ?></h1>
            <div class="prose max-w-none"><?php echo $homepage->content; ?></div>
        </div>
    </main>
<?php else: ?>
    <?php echo $__env->make('frontend.partials.landing-content', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="mb-4">
                    <?php if(isset($settings['logo']) && $settings['logo']): ?>
                        <img src="<?php echo e(asset('storage/' . $settings['logo'])); ?>" alt="<?php echo e($settings['site_name'] ?? 'Logo'); ?>" class="h-10 w-auto">
                    <?php else: ?>
                        <span class="text-2xl font-bold"><?php echo e($settings['site_name'] ?? 'Konter Digital'); ?></span>
                    <?php endif; ?>
                </div>
                <p class="text-gray-400 mb-4"><?php echo e($settings['footer_about'] ?? $settings['site_description'] ?? ''); ?></p>
                <div class="flex space-x-4">
                    <?php if(isset($settings['facebook_url']) && $settings['facebook_url']): ?>
                        <a href="<?php echo e($settings['facebook_url']); ?>" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <?php endif; ?>
                    <?php if(isset($settings['instagram_url']) && $settings['instagram_url']): ?>
                        <a href="<?php echo e($settings['instagram_url']); ?>" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <?php endif; ?>
                    <?php if(isset($settings['twitter_url']) && $settings['twitter_url']): ?>
                        <a href="<?php echo e($settings['twitter_url']); ?>" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                    <?php endif; ?>
                    <?php if(isset($settings['whatsapp_number']) && $settings['whatsapp_number']): ?>
                        <a href="https://wa.me/<?php echo e(str_replace(['+', ' ', '-'], '', $settings['whatsapp_number'])); ?>" target="_blank" class="text-gray-400 hover:text-white transition-colors"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></a>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <?php if($footerMenu && $footerMenu->items): ?>
                        <?php $__currentLoopData = $footerMenu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->is_active): ?>
                                <li><a href="<?php echo e($item->url); ?>" target="<?php echo e($item->target); ?>" class="text-gray-400 hover:text-white transition-colors"><?php echo e($item->title); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-gray-400">
                    <?php if(isset($settings['contact_email']) && $settings['contact_email']): ?>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><span><?php echo e($settings['contact_email']); ?></span></li>
                    <?php endif; ?>
                    <?php if(isset($settings['contact_phone']) && $settings['contact_phone']): ?>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg><span><?php echo e($settings['contact_phone']); ?></span></li>
                    <?php endif; ?>
                    <?php if(isset($settings['contact_address']) && $settings['contact_address']): ?>
                        <li class="flex items-start"><svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span><?php echo e($settings['contact_address']); ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Download App</h3>
                <p class="text-gray-400 mb-4">Dapatkan aplikasi kami sekarang</p>
                <a href="https://play.google.com/store" target="_blank" class="inline-flex items-center bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                    Google Play
                </a>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">&copy; <?php echo e(date('Y')); ?> <?php echo e($settings['site_name'] ?? 'Konter Digital CMS'); ?>. All rights reserved.</p>
                <p class="text-gray-400 text-sm">Powered by <span class="font-semibold text-white">Konter Digital CMS</span></p>
            </div>
        </div>
    </div>
</footer>

<?php $footerAds = \App\Models\Ad::getByPosition('footer', ['page' => request()->route()->getName()]); ?>
<?php $__currentLoopData = $footerAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4"><?php echo $ad->code; ?></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
</body>
</html>
<?php /**PATH E:\MUDK Project\cms\resources\views/frontend/home.blade.php ENDPATH**/ ?>