<?php if (isset($component)) { $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.master','data' => ['title' => 'Import Students']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.master'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Import Students']); ?>

    <div class="max-w-4xl mx-auto">

        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                Import Students
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                Manage your student database by importing records from a CSV file.
            </p>
        </div>

        
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

            <div class="p-8">

                
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-2">Instructions</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                        Please ensure your CSV file follows the required format. The first row must contain the following exact headers:
                        <span class="inline-flex items-center px-2 py-0.5 mt-2 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-mono">
                            name, email, major
                        </span>.
                        Maximum file size is 10MB.
                    </p>
                </div>

                
                <form action="<?php echo e(route('students.import')); ?>" method="POST" enctype="multipart/form-data" id="importForm">
                    <?php echo csrf_field(); ?>

                    
                    <div
                        class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-12 flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary text-4xl">csv</span>
                        </div>
                        <h4 class="text-base font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            Drag and drop your CSV file here
                        </h4>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">
                            or search for the file on your computer
                        </p>
                        <button
                            type="button"
                            class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20"
                        >
                            Choose File
                        </button>

                        
                        <input
                            type="file"
                            name="file"
                            id="fileInput"
                            accept=".csv,.xlsx,.xls"
                            class="hidden"
                        />
                    </div>

                    
                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-3"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    
                    <div id="filePreview" class="mt-6 hidden">
                        <div class="flex items-center gap-4 p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                            <span class="material-symbols-outlined text-primary">description</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium" id="fileName"></p>
                                <p class="text-xs text-slate-500" id="fileSize"></p>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-slate-400 hover:text-red-500">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            
            <div class="px-8 py-5 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-4">
                <a href="<?php echo e(route('students.index')); ?>" class="px-6 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors">
                    Cancel
                </a>
                <button
                    type="submit"
                    form="importForm"
                    class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20"
                >
                    Upload and Import
                </button>
            </div>

        </div>

        
        <div class="mt-8 flex items-center justify-center gap-8">
            <a href="#" class="flex items-center gap-2 text-sm text-primary font-medium hover:underline">
                <span class="material-symbols-outlined text-lg">download</span>
                Download CSV Template
            </a>
            <a href="#" class="flex items-center gap-2 text-sm text-primary font-medium hover:underline">
                <span class="material-symbols-outlined text-lg">help_outline</span>
                View Import Guide
            </a>
        </div>

    </div>

    
    
    <script>
        const fileInput   = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');
        const fileName    = document.getElementById('fileName');
        const fileSize    = document.getElementById('fileSize');
        const dropZone    = document.querySelector('.border-dashed');

        // show file info
        function showFile(file) {
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
            filePreview.classList.remove('hidden');
        }

        // file input change
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) showFile(this.files[0]);
        });

        // clear file
        function clearFile() {
            fileInput.value = '';
            filePreview.classList.add('hidden');
        }

        // drag over — prevent default to allow drop
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary', 'bg-primary/5');
        });

        // drag leave — reset styles
        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('border-primary', 'bg-primary/5');
        });

        // drop — get the file
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary', 'bg-primary/5');

            const file = e.dataTransfer.files[0];
            if (file) {
                // transfer dropped file to the input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                showFile(file);
            }
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $attributes = $__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__attributesOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719)): ?>
<?php $component = $__componentOriginal09ae9edb6a4f3743836239ca1a9c4719; ?>
<?php unset($__componentOriginal09ae9edb6a4f3743836239ca1a9c4719); ?>
<?php endif; ?><?php /**PATH D:\University\University Year 2\Backend Development with Api\Laravel\Student-Management-System\resources\views/students/import.blade.php ENDPATH**/ ?>