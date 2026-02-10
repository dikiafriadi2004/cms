<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();
        $tags = Tag::all();

        if (!$user || $categories->isEmpty()) {
            $this->command->error('Please run CategorySeeder and create a user first!');
            return;
        }

        $posts = [
            [
                'title' => 'Getting Started with Laravel 11',
                'content' => '<p>Laravel 11 brings exciting new features and improvements to the framework. In this comprehensive guide, we\'ll explore the latest additions and how they can enhance your development workflow.</p><p>The new version introduces streamlined application structure, improved performance, and better developer experience. Let\'s dive into the key features that make Laravel 11 a game-changer for modern web development.</p><h2>Key Features</h2><p>Laravel 11 includes several notable improvements including a slimmer application skeleton, per-second rate limiting, and health routing. These enhancements make it easier than ever to build robust web applications.</p>',
                'excerpt' => 'Explore the exciting new features and improvements in Laravel 11 that will enhance your development workflow.',
            ],
            [
                'title' => 'Mastering Tailwind CSS: A Complete Guide',
                'content' => '<p>Tailwind CSS has revolutionized the way we write CSS. This utility-first framework allows developers to build modern, responsive designs without leaving their HTML.</p><p>In this guide, we\'ll cover everything from basic concepts to advanced techniques, helping you become proficient in Tailwind CSS.</p><h2>Why Tailwind CSS?</h2><p>Tailwind provides low-level utility classes that let you build completely custom designs without ever leaving your HTML. It\'s highly customizable and optimized for production.</p>',
                'excerpt' => 'Learn how to master Tailwind CSS and build beautiful, responsive designs with this utility-first framework.',
            ],
            [
                'title' => 'Building RESTful APIs with Laravel',
                'content' => '<p>RESTful APIs are the backbone of modern web applications. Laravel provides excellent tools for building robust, scalable APIs that power your applications.</p><p>This tutorial will guide you through creating a complete RESTful API using Laravel\'s powerful features including resource controllers, API resources, and authentication.</p><h2>API Best Practices</h2><p>We\'ll cover versioning, authentication, rate limiting, and proper error handling to ensure your API is production-ready.</p>',
                'excerpt' => 'A comprehensive guide to building robust and scalable RESTful APIs using Laravel framework.',
            ],
            [
                'title' => 'Understanding JavaScript Async/Await',
                'content' => '<p>Asynchronous programming is crucial in modern JavaScript development. The async/await syntax makes working with promises much more intuitive and readable.</p><p>In this article, we\'ll explore how async/await works, common patterns, and best practices for handling asynchronous operations in JavaScript.</p><h2>From Callbacks to Async/Await</h2><p>We\'ll trace the evolution from callback hell to promises, and finally to the elegant async/await syntax that makes asynchronous code look synchronous.</p>',
                'excerpt' => 'Master asynchronous JavaScript programming with async/await and write cleaner, more maintainable code.',
            ],
            [
                'title' => 'Vue.js 3 Composition API Deep Dive',
                'content' => '<p>Vue.js 3 introduced the Composition API, a new way to organize and reuse logic in Vue components. This powerful feature provides better code organization and TypeScript support.</p><p>Learn how to leverage the Composition API to write more maintainable and scalable Vue applications.</p><h2>Reactive Programming</h2><p>The Composition API brings reactive programming to the forefront, making it easier to manage complex state and side effects in your applications.</p>',
                'excerpt' => 'Explore Vue.js 3 Composition API and learn how to write more organized and reusable component logic.',
            ],
            [
                'title' => 'Database Optimization Techniques',
                'content' => '<p>Database performance is critical for application success. Learn essential optimization techniques including indexing, query optimization, and caching strategies.</p><p>This guide covers practical approaches to improve database performance and reduce query execution time.</p><h2>Indexing Strategies</h2><p>Proper indexing can dramatically improve query performance. We\'ll explore different types of indexes and when to use them effectively.</p>',
                'excerpt' => 'Learn essential database optimization techniques to improve application performance and scalability.',
            ],
            [
                'title' => 'Modern CSS Grid Layout',
                'content' => '<p>CSS Grid Layout is a powerful tool for creating complex, responsive layouts. It provides a two-dimensional grid system that makes layout design intuitive and flexible.</p><p>Discover how to use CSS Grid to build modern, responsive web layouts with ease.</p><h2>Grid vs Flexbox</h2><p>Understanding when to use Grid versus Flexbox is key to efficient layout design. We\'ll compare both and show you when each is most appropriate.</p>',
                'excerpt' => 'Master CSS Grid Layout and create complex, responsive web layouts with this powerful CSS feature.',
            ],
            [
                'title' => 'Docker for Web Developers',
                'content' => '<p>Docker has become an essential tool for modern web development. It provides consistent development environments and simplifies deployment processes.</p><p>Learn how to containerize your applications and leverage Docker for efficient development workflows.</p><h2>Container Basics</h2><p>We\'ll start with Docker fundamentals and progress to advanced topics like multi-container applications and Docker Compose.</p>',
                'excerpt' => 'Get started with Docker and learn how to containerize your web applications for consistent development.',
            ],
            [
                'title' => 'React Hooks: A Practical Guide',
                'content' => '<p>React Hooks revolutionized how we write React components. They allow you to use state and other React features without writing class components.</p><p>This practical guide covers the most commonly used hooks and how to create custom hooks for your applications.</p><h2>useState and useEffect</h2><p>Master the fundamental hooks that form the foundation of modern React development and learn best practices for using them effectively.</p>',
                'excerpt' => 'Learn React Hooks and discover how to write cleaner, more functional React components.',
            ],
            [
                'title' => 'Web Security Best Practices',
                'content' => '<p>Security should be a top priority in web development. Learn essential security practices to protect your applications from common vulnerabilities.</p><p>This guide covers OWASP Top 10 vulnerabilities and how to prevent them in your applications.</p><h2>Common Vulnerabilities</h2><p>We\'ll explore SQL injection, XSS, CSRF, and other common security threats, along with practical solutions to mitigate them.</p>',
                'excerpt' => 'Essential web security practices to protect your applications from common vulnerabilities and attacks.',
            ],
            [
                'title' => 'GraphQL vs REST: Choosing the Right API',
                'content' => '<p>GraphQL and REST are two popular approaches to building APIs. Each has its strengths and use cases.</p><p>This comparison will help you understand the differences and choose the right approach for your project.</p><h2>API Design Patterns</h2><p>Learn about the architectural differences, performance considerations, and developer experience of both GraphQL and REST APIs.</p>',
                'excerpt' => 'Compare GraphQL and REST APIs to make informed decisions about your API architecture.',
            ],
            [
                'title' => 'TypeScript for JavaScript Developers',
                'content' => '<p>TypeScript adds static typing to JavaScript, making your code more robust and maintainable. It\'s become the standard for large-scale JavaScript applications.</p><p>Learn how to adopt TypeScript in your projects and leverage its powerful type system.</p><h2>Type Safety Benefits</h2><p>Discover how TypeScript\'s type system catches errors at compile time and improves code quality and developer productivity.</p>',
                'excerpt' => 'Learn TypeScript and add type safety to your JavaScript applications for better code quality.',
            ],
            [
                'title' => 'Progressive Web Apps (PWA) Guide',
                'content' => '<p>Progressive Web Apps combine the best of web and mobile apps. They\'re reliable, fast, and engaging, providing app-like experiences on the web.</p><p>Learn how to build PWAs that work offline and provide native app experiences.</p><h2>Service Workers</h2><p>Service workers are the backbone of PWAs, enabling offline functionality and background sync. We\'ll explore how to implement them effectively.</p>',
                'excerpt' => 'Build Progressive Web Apps that provide app-like experiences with offline capabilities and push notifications.',
            ],
            [
                'title' => 'Git Workflow Best Practices',
                'content' => '<p>Effective Git workflows are essential for team collaboration. Learn industry-standard practices for branching, merging, and code review.</p><p>This guide covers Git Flow, GitHub Flow, and other popular workflows to help your team work efficiently.</p><h2>Branching Strategies</h2><p>Understand different branching strategies and choose the one that fits your team\'s needs and project requirements.</p>',
                'excerpt' => 'Master Git workflows and improve team collaboration with industry-standard version control practices.',
            ],
            [
                'title' => 'Microservices Architecture Explained',
                'content' => '<p>Microservices architecture breaks applications into small, independent services. This approach offers scalability and flexibility but comes with its own challenges.</p><p>Learn when to use microservices and how to implement them effectively.</p><h2>Service Communication</h2><p>Explore different patterns for service-to-service communication including REST, message queues, and event-driven architectures.</p>',
                'excerpt' => 'Understand microservices architecture and learn when and how to implement it in your applications.',
            ],
            [
                'title' => 'Testing JavaScript Applications',
                'content' => '<p>Testing is crucial for maintaining code quality and preventing bugs. Learn how to write effective tests for your JavaScript applications.</p><p>This guide covers unit testing, integration testing, and end-to-end testing with popular tools like Jest and Cypress.</p><h2>Test-Driven Development</h2><p>Discover the benefits of TDD and how to incorporate it into your development workflow for better code quality.</p>',
                'excerpt' => 'Learn how to write effective tests for JavaScript applications using modern testing frameworks and tools.',
            ],
            [
                'title' => 'Responsive Design Principles',
                'content' => '<p>Responsive design ensures your website looks great on all devices. Learn the principles and techniques for creating truly responsive web experiences.</p><p>We\'ll cover mobile-first design, breakpoints, and flexible layouts that adapt to any screen size.</p><h2>Mobile-First Approach</h2><p>Starting with mobile design and progressively enhancing for larger screens leads to better user experiences and cleaner code.</p>',
                'excerpt' => 'Master responsive design principles and create websites that look great on all devices and screen sizes.',
            ],
            [
                'title' => 'Node.js Performance Optimization',
                'content' => '<p>Node.js performance optimization is crucial for building scalable applications. Learn techniques to improve your Node.js application\'s speed and efficiency.</p><p>This guide covers profiling, caching, clustering, and other optimization strategies.</p><h2>Event Loop Understanding</h2><p>Understanding the Node.js event loop is key to writing performant applications. We\'ll explore how it works and how to optimize for it.</p>',
                'excerpt' => 'Optimize your Node.js applications for better performance and scalability with proven techniques.',
            ],
            [
                'title' => 'CSS Animation and Transitions',
                'content' => '<p>CSS animations and transitions bring your web pages to life. Learn how to create smooth, performant animations that enhance user experience.</p><p>We\'ll cover keyframe animations, transitions, and best practices for animation performance.</p><h2>Performance Considerations</h2><p>Not all CSS properties are created equal when it comes to animation. Learn which properties to animate for the best performance.</p>',
                'excerpt' => 'Create smooth, performant CSS animations and transitions that enhance your website\'s user experience.',
            ],
            [
                'title' => 'Building Scalable Web Applications',
                'content' => '<p>Scalability is essential for growing applications. Learn architectural patterns and best practices for building applications that can handle increasing load.</p><p>This comprehensive guide covers horizontal scaling, caching strategies, and database optimization.</p><h2>Load Balancing</h2><p>Distribute traffic across multiple servers to ensure your application remains responsive under heavy load. We\'ll explore different load balancing strategies.</p>',
                'excerpt' => 'Learn how to build scalable web applications that can grow with your user base and handle increasing traffic.',
            ],
        ];

        foreach ($posts as $index => $postData) {
            $post = Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'content' => $postData['content'],
                'excerpt' => $postData['excerpt'],
                'user_id' => $user->id,
                'category_id' => $categories->random()->id,
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'views_count' => rand(50, 1000),
                'meta_title' => $postData['title'],
                'meta_description' => $postData['excerpt'],
            ]);

            // Attach random tags (1-3 tags per post)
            if ($tags->isNotEmpty()) {
                $post->tags()->attach(
                    $tags->random(rand(1, min(3, $tags->count())))->pluck('id')->toArray()
                );
            }
        }

        $this->command->info('20 posts created successfully!');
    }
}
