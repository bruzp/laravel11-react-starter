import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import { format } from "date-fns";
import TextInput from "@/Components/TextInput";
import TableHeading from "@/Components/TableHeading";

export default function QuestionnaireIndex({
  auth,
  questionnaires,
  status,
  query_params,
}) {
  query_params = query_params || {};

  const destroy = (id, name) => {
    router.delete(route("admin.questionnaires.destroy", id), {
      onBefore: () =>
        confirm(
          "Are you sure you want to delete this questionnaire {" + name + "}?"
        ),
    });
  };

  const searchFieldChanged = (name, value) => {
    if (value) {
      query_params[name] = value;
    } else {
      delete query_params[name];
    }

    router.get(route("admin.questionnaires.index"), query_params);
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
    router.get(route("admin.questionnaires.index"), query_params);
  };

  const limitString = (str, max_length) => {
    return str.length > max_length ? str.slice(0, max_length) + "..." : str;
  };

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Questionnaires
          </h2>
          <Link
            href={route("admin.questionnaires.create")}
            className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
          >
            Add new
          </Link>
        </div>
      }
    >
      <Head title="Admin Questionnaires" />

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
                          Title
                        </TableHeading>
                        <TableHeading
                          name="description"
                          sort_field={query_params.order_by}
                          sort_direction={query_params.order}
                          sortChanged={sortChanged}
                        >
                          Description
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
                        <th colSpan={2} className="px-3 py-3">
                          <TextInput
                            defaultValue={query_params.search}
                            className="w-full"
                            autoComplete="off"
                            placeholder="Search Questionnaire"
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
                      {questionnaires.data.map((questionnaire) => (
                        <tr
                          className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                          key={questionnaire.id}
                        >
                          <td className="px-3 py-2">{questionnaire.id}</td>
                          <td className="px-3 py-2">{questionnaire.title}</td>
                          <td className="px-3 py-2">
                            {limitString(questionnaire.description, 100)}
                          </td>
                          <td className="px-3 py-2">
                            {questionnaire.created_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
                            {questionnaire.updated_at_for_humans}
                          </td>
                          <td className="px-3 py-2">
                            <Link
                              className="text-yellow-500 hover:text-yellow-700 mr-3"
                              href={route(
                                "admin.questionnaires.edit",
                                questionnaire.id
                              )}
                            >
                              Edit
                            </Link>
                            <button
                              onClick={() =>
                                destroy(questionnaire.id, questionnaire.title)
                              }
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
                <Pagination class="mt-6" links={questionnaires.meta.links} />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
