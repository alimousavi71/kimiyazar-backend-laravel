@props([
    'name' => 'editor',
    'id' => null,
    'value' => '',
    'label' => null,
    'error' => null,
    'required' => false,
    'height' => 400,
    'placeholder' => '',
    'toolbar' => 'full', // 'full', 'basic', 'minimal'
])

@php
    $id = $id ?? $name;
    $editorId = 'editor-' . $id;
@endphp

@push('styles')
    <style>
        .editor-wrapper-{{ $editorId }} {
            direction: rtl;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-container {
            direction: rtl;
            text-align: right;
            font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif;
            min-height: {{ $height }}px;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-editor {
            direction: rtl;
            text-align: right;
            min-height: {{ $height }}px;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-toolbar {
            direction: rtl;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-toolbar.ql-snow {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-container.ql-snow {
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 0.75rem 0.75rem;
        }
        
        .editor-wrapper-{{ $editorId }} .ql-container.ql-snow:focus-within {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
        }
    </style>
@endpush

<div class="flex flex-col gap-1" x-data="{ 
    editor: null,
    content: @js($value),
    init() {
        // Wait for Quill to be loaded from npm
        if (typeof Quill !== 'undefined') {
            this.initEditor();
        } else {
            // Wait for Quill to be available (loaded via vite)
            const checkQuill = setInterval(() => {
                if (typeof Quill !== 'undefined') {
                    clearInterval(checkQuill);
                    this.initEditor();
                }
            }, 100);
            
            // Timeout after 5 seconds
            setTimeout(() => {
                clearInterval(checkQuill);
                if (typeof Quill === 'undefined') {
                    console.error('Quill editor failed to load');
                }
            }, 5000);
        }
    },
    async initEditor() {
        await this.$nextTick();
        
        const toolbarOptions = this.getToolbar();
        
        const config = {
            theme: 'snow',
            placeholder: @js($placeholder),
            modules: {
                toolbar: toolbarOptions
            },
            direction: 'rtl'
        };

        try {
            this.editor = new Quill('#' + @js($editorId), config);
            
            // Set initial content
            if (this.content) {
                this.editor.root.innerHTML = this.content;
            }
            
            // Update hidden textarea on change
            this.editor.on('text-change', () => {
                const html = this.editor.root.innerHTML;
                const text = this.editor.getText();
                // Only update if there's actual content (not just empty paragraph)
                if (text.trim() || html !== '<p><br></p>') {
                    document.getElementById(@js($id)).value = html;
                } else {
                    document.getElementById(@js($id)).value = '';
                }
            });
        } catch (error) {
            console.error('Error initializing Quill:', error);
        }
    },
    getToolbar() {
        const toolbars = {
            full: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ],
            basic: [
                ['bold', 'italic'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link']
            ],
            minimal: [
                ['bold', 'italic'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        };
        return toolbars[@js($toolbar)] || toolbars.full;
    }
}">
    @if($label)
        <label class="text-sm font-medium text-gray-700" for="{{ $id }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="editor-wrapper editor-wrapper-{{ $editorId }}">
        <div id="{{ $editorId }}"></div>
        <textarea 
            name="{{ $name }}" 
            id="{{ $id }}" 
            class="hidden"
            {{ $required ? 'required' : '' }}
        >{{ $value }}</textarea>
    </div>

    @if($error)
        <span class="text-sm text-red-600">{{ $error }}</span>
    @endif
</div>

