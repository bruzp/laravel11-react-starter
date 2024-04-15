import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

export default function Dashboard({ auth }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
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
        post(route("admin.users.store"));
    }

    return (
        <AuthenticatedLayout
            admin={auth.admin}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Create User
                </h2>
            }
        >
            <Head title="Admin Create User" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            Create User
                        </div>
                        <div className="flex flex-col">
                            <div className="overflow-x-auto">
                                <div className="pl-5 pr-5 w-full inline-block align-middle">
                                    <form onSubmit={handleSubmit}>
                                        <div className="mb-5">
                                            <InputLabel
                                                htmlFor="name"
                                                value="Name"
                                            />

                                            <TextInput
                                                id="name"
                                                type="text"
                                                name="name"
                                                value={data.name}
                                                className="mt-1 block w-full"
                                                autoComplete="off"
                                                isFocused={true}
                                                onChange={handleOnChange}
                                            />

                                            <InputError
                                                message={errors.name}
                                                className="mt-2"
                                            />
                                        </div>

                                        <div className="mb-5">
                                            <InputLabel
                                                htmlFor="email"
                                                value="Email"
                                            />

                                            <TextInput
                                                id="email"
                                                type="email"
                                                name="email"
                                                value={data.email}
                                                className="mt-1 block w-full"
                                                autoComplete="off"
                                                onChange={handleOnChange}
                                            />

                                            <InputError
                                                message={errors.email}
                                                className="mt-2"
                                            />
                                        </div>

                                        <div className="mb-5">
                                            <InputLabel
                                                htmlFor="password"
                                                value="Password"
                                            />

                                            <TextInput
                                                id="password"
                                                type="password"
                                                name="password"
                                                value={data.password}
                                                className="mt-1 block w-full"
                                                autoComplete="off"
                                                onChange={handleOnChange}
                                            />

                                            <InputError
                                                message={errors.password}
                                                className="mt-2"
                                            />
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
                                                value={
                                                    data.password_confirmation
                                                }
                                                className="mt-1 block w-full"
                                                autoComplete="off"
                                                onChange={handleOnChange}
                                            />

                                            <InputError
                                                message={
                                                    errors.password_confirmation
                                                }
                                                className="mt-2"
                                            />
                                        </div>

                                        <div className="flex items-center justify-end mt-4 mb-5">
                                            <PrimaryButton
                                                className="ml-4"
                                                disabled={processing}
                                            >
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
