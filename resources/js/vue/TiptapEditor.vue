<script setup>
import { Editor, EditorContent } from '@tiptap/vue-3';
import { onBeforeUnmount, onMounted, shallowRef, watch } from 'vue';

const props = defineProps({
  config: { type: Object, required: true },
  modelValue: { type: [Object, String, null], default: null },
});

const emit = defineEmits(['update:modelValue', 'create', 'update', 'focus', 'blur']);
const editor = shallowRef(null);
const isSafeImportPath = (path) => /^@tiptap\/[a-z0-9-/]+$/i.test(path);

const resolveExtensions = async (definitions = []) => {
  const loaded = [];
  for (const definition of definitions) {
    if (!definition?.enabled || !definition?.import) continue;
    if (!isSafeImportPath(definition.import)) continue;
    const module = await import(/* @vite-ignore */ definition.import);
    const extensionClass = module.default ?? module[definition.name] ?? Object.values(module)[0];
    if (!extensionClass) continue;
    loaded.push(typeof extensionClass.configure === 'function' ? extensionClass.configure(definition.config ?? {}) : extensionClass);
  }
  return loaded;
};

onMounted(async () => {
  const extensions = await resolveExtensions(props.config.extensions || []);

  editor.value = new Editor({
    ...(props.config.options || {}),
    content: props.modelValue ?? props.config?.options?.content,
    extensions,
    onCreate: (e) => emit('create', e),
    onUpdate: (e) => {
      emit('update:modelValue', e.editor.getJSON());
      emit('update', e);
    },
    onFocus: (e) => emit('focus', e),
    onBlur: (e) => emit('blur', e),
  });
});

watch(() => props.modelValue, (value) => {
  if (!editor.value) return;
  if (value === null || value === undefined) return;
  editor.value.commands.setContent(value, false);
});

onBeforeUnmount(() => {
  editor.value?.destroy();
});
</script>

<template>
  <EditorContent v-if="editor" :editor="editor" />
</template>
