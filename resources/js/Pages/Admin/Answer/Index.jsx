import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import { format } from "date-fns";
import TextInput from "@/Components/TextInput";
import TableHeading from "@/Components/TableHeading";

export default function AnswersIndex({
  auth,
  answers,
  status,
  query_params = null,
}) {
  query_params = query_params || {};

  const destroy = (id, name) => {
    router.delete(route("admin.answers.destroy", id), {
      onBefore: () =>
        confirm("Are you sure you want to delete this answer {" + name + "}?"),
    });
  };

  const searchFieldChanged = (name, value) => {
    if (value) {
      query_params[name] = value;
    } else {
      delete query_params[name];
    }

    router.get(route("admin.answers.index"), query_params);
  };

  const onKeyPress = (name, e) => {
    if (e.key !== "Enter") return;

    searchFieldChanged(name, e.target.value);
  };

  const sortChanged = (name) => {
    if (name === query_params.order_by) {
      if (query_params.order === "asc") {
        query_params.order = "desc";
      } else {
        query_params.order = "asc";
      }
    } else {
      query_params.order_by = name;
      query_params.order = "asc";
    }
    router.get(route("admin.answers.index"), query_params);
  };

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Answers
          </h2>
        </div>
      }
    >
      <Head title="Admin Answers" />

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
                          name="title"
                          sort_field={query_params.order_by}
                          sort_direction={query_params.order}
                          sortChanged={sortChanged}
                        >
                          Questionnaire
                        </TableHeading>
                        <TableHeading
                          name="name"
                          sort_field={query_params.order_by}
                          sort_direction={query_params.order}
                          sortChanged={sortChanged}
                        >
                          Examinee Name
                        </TableHeading>
                        <TableHeading
                          name="email"
                          sort_field={query_params.order_by}
                          sort_direction={query_params.order}
                          sortChanged={sortChanged}
                        >
                          Examinee Email
                        </TableHeading>
                        <TableHeading
                          name="result"
                          sort_field={query_params.order_by}
                          sort_direction={query_params.order}
                          sortChanged={sortChanged}
                        >
                          Result
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
                    </thead>
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                      <tr className="text-nowrap">
                        <th className="px-3 py-3"></th>
                        <th colSpan={3} className="px-3 py-3">
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
                        <th className="px-3 py-3"></th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                      {answers.data.map((answer) => (
                        <tr
                          className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                          key={answer.id}
                        >
                          <td className="px-3 py-2">{answer.id}</td>
                          <td className="px-3 py-2">{answer.title}</td>
                          <td className="px-3 py-2">{answer.name}</td>
                          <td className="px-3 py-2">{answer.email}</td>
                          <td className="px-3 py-2">{answer.result}%</td>
                          <td className="px-3 py-2">
                            {answer.created_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
                            {answer.updated_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
                            <button
                              onClick={() => destroy(answer.id, answer.name)}
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
                <Pagination class="mt-6" links={answers.meta.links} />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
