import { Editor } from '@tiptap/core';

const isSafeImportPath = (path) => /^@tiptap\/[a-z0-9-/]+$/i.test(path);

const resolveExtensions = async (definitions = []) => {
  const loaded = [];

  for (const definition of definitions) {
    if (!definition?.enabled) continue;
    if (!definition.import) continue;
    if (!isSafeImportPath(definition.import)) continue;

    const module = await import(/* @vite-ignore */ definition.import);
    const extensionClass = module.default ?? module[definition.name] ?? Object.values(module)[0];

    if (!extensionClass) continue;

    if (typeof extensionClass.configure === 'function') {
      loaded.push(extensionClass.configure(definition.config ?? {}));
      continue;
    }

    loaded.push(extensionClass);
  }

  return loaded;
};

export const mountLaravelTiptap = async (element) => {
  const raw = element.getAttribute('data-tiptap') || '{}';
  const config = JSON.parse(raw);
  const extensions = await resolveExtensions(config.extensions || []);

  const editor = new Editor({
    ...(config.options || {}),
    element,
    extensions,
    onCreate: (props) => window.dispatchEvent(new CustomEvent('tiptap:create', { detail: props })),
    onUpdate: (props) => {
      const hidden = element.parentElement?.querySelector('input[type="hidden"]');
      if (hidden) hidden.value = JSON.stringify(props.editor.getJSON());
      window.dispatchEvent(new CustomEvent('tiptap:update', { detail: props }));
    },
  });

  for (const command of config.commands || []) {
    const fn = editor.commands?.[command.name];
    if (typeof fn === 'function') fn(command.payload ?? {});
  }

  return editor;
};
