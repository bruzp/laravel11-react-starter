import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import TextAreaInput from "@/Components/TextAreaInput";
import { useCallback } from "react";

export default function QuestionnaireCreate({ auth }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    title: "",
    description: "",
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
      post(route("admin.questionnaires.store"));
    },
    [post]
  );

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Create Questionnaire
        </h2>
      }
    >
      <Head title="Admin Create Questionnaire" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              Create Questionnaire
            </div>
            <div className="flex flex-col">
              <div className="overflow-x-auto">
                <div className="pl-5 pr-5 w-full inline-block align-middle">
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
