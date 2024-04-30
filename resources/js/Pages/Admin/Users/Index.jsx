import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import { format } from "date-fns";
import TextInput from "@/Components/TextInput";
import TableHeading from "@/Components/TableHeading";
import { useCallback, useMemo } from "react";

export default function UsersIndex({ auth, users, status, query_params = {} }) {
  query_params = query_params || {};

  const destroy = useCallback((id, name) => {
    if (confirm(`Are you sure you want to delete this user ${name}?`)) {
      router.delete(route("admin.users.destroy", id));
    }
  }, []);

  /* Immutability Principle */
  const searchFieldChanged = useCallback(
    (name, value) => {
      const newParams = { ...query_params, [name]: value || undefined };
      router.get(route("admin.users.index"), newParams);
    },
    [query_params]
  );

  const sortChanged = useCallback(
    (name) => {
      const newParams = { ...query_params };
      if (name === newParams.order_by) {
        newParams.order = newParams.order === "asc" ? "desc" : "asc";
      } else {
        newParams.order_by = name;
        newParams.order = "asc";
      }
      router.get(route("admin.users.index"), newParams);
    },
    [query_params]
  );

  const onKeyPress = useCallback(
    (name, e) => {
      if (e.key === "Enter") {
        searchFieldChanged(name, e.target.value);
      }
    },
    [searchFieldChanged]
  );

  const tableHeaders = useMemo(
    () => (
      <tr className="text-nowrap">
        <TableHeading
          name="id"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          ID
        </TableHeading>
        <TableHeading
          name="name"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          Name
        </TableHeading>
        <TableHeading
          name="email"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          Email
        </TableHeading>
        <TableHeading
          name="created_at"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          Create Date
        </TableHeading>
        <TableHeading
          name="updated_at"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          Update Date
        </TableHeading>
        <th className="px-3 py-3 text-left">Actions</th>
      </tr>
    ),
    [query_params.order_by, query_params.order, sortChanged]
  );

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Users
          </h2>
          <Link
            href={route("admin.users.create")}
            className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
          >
            Add new
          </Link>
        </div>
      }
    >
      <Head title="Admin Users" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div className="p-6 text-gray-900 dark:text-gray-100">
                {status && (
                  <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                  </div>
                )}
                <div className="overflow-auto">
                  <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      {tableHeaders}
                    </thead>
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      <tr className="text-nowrap">
                        <th className="px-3 py-3"></th>
                        <th colSpan={2} className="px-3 py-3">
                          <TextInput
                            defaultValue={query_params.search}
                            className="w-full"
                            autoComplete="off"
                            placeholder="Search Name"
                            onBlur={(e) =>
                              searchFieldChanged("search", e.target.value)
                            }
                            onKeyPress={(e) => onKeyPress("search", e)}
                          />
                        </th>
                        <th className="px-3 py-3"></th>
                        <th className="px-3 py-3"></th>
                        <th className="px-3 py-3"></th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                      {users.data.map((user) => (
                        <tr
                          className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                          key={user.id}
                        >
                          <td className="px-3 py-2">{user.id}</td>
                          <td className="px-3 py-2">{user.name}</td>
                          <td className="px-3 py-2">{user.email}</td>
                          <td className="px-3 py-2">
                            {user.created_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
                            {user.updated_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
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
                <Pagination className="mt-6" links={users.meta.links} />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
