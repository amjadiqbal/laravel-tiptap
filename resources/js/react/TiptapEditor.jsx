import React, { useEffect } from 'react';
import { useEditor, EditorContent } from '@tiptap/react';

const useResolvedExtensions = (extensions = []) => {
  return extensions;
};

export default function TiptapEditor({ config, value, onChange, onCreate, onUpdate, onFocus, onBlur }) {
  const extensions = useResolvedExtensions(config?.extensions || []);

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
