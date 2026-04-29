import React, { useEffect, useMemo, useState } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';

const isSafeImportPath = (path) => /^@tiptap\/[a-z0-9-/]+$/i.test(path);

export default function TiptapEditor({ config, value, onChange, onCreate, onUpdate, onFocus, onBlur }) {
  const extensionDefinitions = useMemo(() => config?.extensions || [], [config?.extensions]);
  const [extensions, setExtensions] = useState([]);

  useEffect(() => {
    let mounted = true;

    const resolveExtensions = async () => {
      const loaded = [];

      for (const definition of extensionDefinitions) {
        if (!definition?.enabled || !definition?.import) continue;
        if (!isSafeImportPath(definition.import)) continue;

        const module = await import(/* @vite-ignore */ definition.import);
        const extensionClass = module.default ?? module[definition.name] ?? Object.values(module)[0];

        if (!extensionClass) continue;

        loaded.push(typeof extensionClass.configure === 'function' ? extensionClass.configure(definition.config ?? {}) : extensionClass);
      }

      if (mounted) {
        setExtensions(loaded);
      }
    };

    resolveExtensions();

    return () => {
      mounted = false;
    };
  }, [extensionDefinitions]);

  const editor = useEditor({
    ...(config?.options || {}),
    content: value ?? config?.options?.content,
    extensions,
    onCreate,
    onUpdate: (ctx) => {
      onChange?.(ctx.editor.getJSON());
      onUpdate?.(ctx);
    },
    onFocus,
    onBlur,
  });

  useEffect(() => {
    if (!editor || value === undefined || value === null) return;
    editor.commands.setContent(value, false);
  }, [editor, value]);

  return <EditorContent editor={editor} />;
}
