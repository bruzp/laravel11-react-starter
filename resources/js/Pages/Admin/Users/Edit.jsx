import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, useForm, usePage } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { useState, useEffect } from "react";
import { useCallback } from "react";

export default function UsersEdit({ auth, user, status }) {
  const { data, setData, put, processing, errors, reset } = useForm({
    id: user.id,
    name: user.name,
    email: user.email,
    password: "",
    password_confirmation: "",
  });

  useEffect(() => {
    return () => {
      reset("password", "password_confirmation");
    };
  }, []);

  const [name, setName] = useState(user.name);

  const handleOnChange = useCallback(
    (event) => {
      setData(
        event.target.name,
        event.target.type === "checkbox"
          ? event.target.checked
          : event.target.value
      );

      if (event.target.name == "name") {
        setName(event.target.value);
      }
    },
    [setData]
  );

  const handleSubmit = useCallback(
    (e) => {
      e.preventDefault();
      put(route("admin.users.update", user));
    },
    [put, user]
  );

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Edit User
        </h2>
      }
    >
      <Head title="Admin Edit User" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              Edit User: {name}
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
                      <InputLabel htmlFor="name" value="Name" />

                      <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoComplete="off"
                        isFocused={true}
                        onChange={handleOnChange}
                      />

                      <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div className="mb-5">
                      <InputLabel htmlFor="email" value="Email" />

                      <TextInput
                        id="email"
                        type="text"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="off"
                        onChange={handleOnChange}
                      />

                      <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="mb-5">
                      <InputLabel htmlFor="password" value="Password" />

                      <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="off"
                        onChange={handleOnChange}
                      />

                      <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="mb-5">
                      <InputLabel
                        htmlFor="password_confirmation"
                        value="Password Confirmation"
                      />

                      <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="off"
                        onChange={handleOnChange}
                      />

                      <InputError
                        message={errors.password_confirmation}
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
