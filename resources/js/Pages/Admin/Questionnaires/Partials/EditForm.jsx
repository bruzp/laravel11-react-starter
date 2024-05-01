import { useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import TextAreaInput from "@/Components/TextAreaInput";
import { useCallback } from "react";

export default function EditForm({ className = "", questionnaire, status }) {
  const { data, setData, put, processing, errors } = useForm({
    title: questionnaire.title,
    description: questionnaire.description,
  });

  const handleOnChange = useCallback(
    (event) => {
      setData(
        event.target.name,
        event.target.type === "checkbox"
          ? event.target.checked
          : event.target.value
      );
    },
    [setData]
  );

  const handleSubmit = useCallback(
    (e) => {
      e.preventDefault();
      put(route("admin.questionnaires.update", questionnaire));
    },
    [put, questionnaire]
  );

  return (
    <section className={className}>
      <header>
        <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit Questionnaire
        </h2>
      </header>

      {status && (
        <div className="mb-4 font-medium text-sm text-green-600">{status}</div>
      )}

      <form onSubmit={handleSubmit} className="mt-6 space-y-6">
        <div className="mb-5">
          <InputLabel htmlFor="title" value="Name" />

          <TextInput
            id="title"
            name="title"
            value={data.title}
            className="mt-1 block w-full"
            autoComplete="off"
            isFocused={true}
            onChange={handleOnChange}
          />

          <InputError message={errors.title} className="mt-2" />
        </div>

        <div className="mb-5">
          <InputLabel htmlFor="description" value="Description" />

          <TextAreaInput
            id="description"
            name="description"
            value={data.description}
            className="mt-1 block w-full"
            autoComplete="off"
            onChange={handleOnChange}
          />

          <InputError message={errors.description} className="mt-2" />
        </div>

        <div className="flex items-center justify-end mt-4 mb-5">
          <PrimaryButton className="ml-4" disabled={processing}>
            Submit
          </PrimaryButton>
        </div>
      </form>
    </section>
  );
}
