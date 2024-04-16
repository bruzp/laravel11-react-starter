import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import TextAreaInput from "@/Components/TextAreaInput";

export default function Dashboard({ auth, questionnaire, status }) {
  const { data, setData, put, processing, errors } = useForm({
    title: questionnaire.title,
    description: questionnaire.description,
  });

  function handleOnChange(event) {
    setData(
      event.target.name,
      event.target.type === "checkbox"
        ? event.target.checked
        : event.target.value
    );
  }

  function handleSubmit(e) {
    e.preventDefault();
    put(route("admin.questionnaires.update", questionnaire));
  }

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Edit Questionnaire
        </h2>
      }
    >
      <Head title="Admin Edit Questionnaire" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              Edit Questionnaire
            </div>
            <div className="flex flex-col">
              <div className="overflow-x-auto">
                <div className="pl-5 pr-5 w-full inline-block align-middle">
                  {status && (
                    <div className="mb-4 font-medium text-sm text-green-600">
                      {status}
                    </div>
                  )}

                  <form onSubmit={handleSubmit}>
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

                      <InputError
                        message={errors.description}
                        className="mt-2"
                      />
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-5">
                      <PrimaryButton className="ml-4" disabled={processing}>
                        Submit
                      </PrimaryButton>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
