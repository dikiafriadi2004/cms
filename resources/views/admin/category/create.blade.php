<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto">
            Add Category
        </h2>
    </div>
    <div id="input" class="p-5">
        <div class="preview">
            <div>
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <label for="regular-form-1" class="form-label">Category Name</label>
                    <input id="regular-form-1" type="text" name="name" class="form-control" placeholder="Category Name">
                    <button type="submit" class="btn btn-primary mt-5">Save</button>
                </form>
            </div>
           
        </div>
    </div>
</div>