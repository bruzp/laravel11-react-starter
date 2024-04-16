import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import { format } from "date-fns";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";

export default function Dashboard({ auth, users, status, search }) {
  const { data, setData, get } = useForm({
    search: search,
    order_by: "updated_at",
    order: "desc",
  });

  function destroy(id, name) {
    router.delete(route("admin.users.destroy", id), {
      onBefore: () =>
        confirm("Are you sure you want to delete this user {" + name + "}?"),
    });
  }

  function handleOnChange(event) {
    setData(
      event.target.name,
      event.target.type === "checkbox"
        ? event.target.checked
        : event.target.value
    );

    if (event.target.name == "name") {
      setName(event.target.value);
    }
  }

  function handleSubmit(e) {
    e.preventDefault();
    get(route("admin.users.index"));
  }

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Users
        </h2>
      }
    >
      <Head title="Admin Users" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="pl-6 pt-6">
              <Link
                className="text-yellow-500 hover:text-yellow-700 mr-3"
                href={route("admin.users.create")}
              >
                Create New User
              </Link>
            </div>

            <div className="p-6 text-gray-900 dark:text-gray-100">
              Users Table
            </div>

            <div className="pl-6 pb-6 col-span-3">
              <InputLabel htmlFor="search" value="Search" />

              <TextInput
                id="search"
                type="text"
                name="search"
                value={data.search}
                className="mt-1"
                autoComplete="off"
                onChange={handleOnChange}
                onBlur={handleSubmit}
              />

              <InputError message="" className="mt-2" />
            </div>

            <div className="flex flex-col">
              <div className="overflow-x-auto">
                <div className="pl-5 pr-5 w-full inline-block align-middle">
                  {status && (
                    <div className="mb-4 font-medium text-sm text-green-600">
                      {status}
                    </div>
                  )}
                  <div className="overflow-hidden border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                      <thead className="bg-gray-50">
                        <tr>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase "
                          >
                            ID
                          </th>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase "
                          >
                            Name
                          </th>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase "
                          >
                            Email
                          </th>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase "
                          >
                            Created At
                          </th>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase "
                          >
                            Updated At
                          </th>
                          <th
                            scope="col"
                            className="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase "
                          >
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-gray-200">
                        {users.data.map((user) => (
                          <tr key={user.id}>
                            <td className="px-6 py-4 text-sm font-medium text-white whitespace-nowrap">
                              {user.id}
                            </td>
                            <td className="px-6 py-4 text-sm text-white whitespace-nowrap">
                              {user.name}
                            </td>
                            <td className="px-6 py-4 text-sm text-white whitespace-nowrap">
                              {user.email}
                            </td>
                            <td className="px-6 py-4 text-sm text-white whitespace-nowrap">
                              {user.created_at}
                            </td>
                            <td className="px-6 py-4 text-sm text-white whitespace-nowrap">
                              {user.updated_at}
                            </td>
                            <td className="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                              <Link
                                className="text-yellow-500 hover:text-yellow-700 mr-3"
                                href={route("admin.users.edit", user.id)}
                              >
                                Edit
                              </Link>
                              <button
                                onClick={() => destroy(user.id, user.name)}
                                type="button"
                                className="text-red-500 hover:text-red-700"
                              >
                                Delete
                              </button>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>

                  <Pagination class="mt-6" links={users.links} />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
