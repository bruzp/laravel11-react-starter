import FrontendLayout from "@/Layouts/Frontend/Layout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import { format } from "date-fns";
import TextInput from "@/Components/Frontend/TextInput";
import TableHeading from "@/Components/TableHeading";
import { useCallback } from "react";
import { useMemo } from "react";

export default function Exam({
  auth,
  questionnaires,
  query_params,
  user_answers,
}) {
  query_params = query_params || {};

  /* Immutability Principle */
  const searchFieldChanged = useCallback(
    (name, value) => {
      const newParams = { ...query_params, [name]: value || undefined };
      router.get(route("exams"), newParams);
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
      router.get(route("exams"), newParams);
    },
    [query_params]
  );

  const onKeyPress = useCallback(
    (name, e) => {
      if (e.key !== "Enter") return;

      searchFieldChanged(name, e.target.value);
    },
    [searchFieldChanged]
  );

  const limitString = useCallback((str, max_length) => {
    return str.length > max_length ? str.slice(0, max_length) + "..." : str;
  }, []);

  const tableHeaders = useMemo(
    () => (
      <tr className="text-nowrap">
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
          name="updated_at"
          sort_field={query_params.order_by}
          sort_direction={query_params.order}
          sortChanged={sortChanged}
        >
          Update Date
        </TableHeading>
      </tr>
    ),
    [query_params.order_by, query_params.order, sortChanged]
  );

  return (
    <FrontendLayout user={auth.user}>
      <Head title="Exam" />

      <div className="grid gap-0 lg:grid-cols-1 lg:gap-8">
        <div className="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
          <div className="w-full">
            <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
              Search Exams
            </h2>

            <table className="w-full text-left rtl:text-right">
              <thead className="text-xs uppercase">{tableHeaders}</thead>
              <thead className="text-xs uppercase">
                <tr className="text-nowrap">
                  <th className="px-3 py-3"></th>
                  <th className="px-3 py-3"></th>
                  <th className="px-3 py-3">
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
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-200">
                {questionnaires.data.map((questionnaire) => (
                  <tr className="border-b" key={questionnaire.id}>
                    <td className="px-3 py-2">
                      {auth.user && !user_answers.includes(questionnaire.id) ? (
                        <Link
                          className="text-blue-500 hover:text-blue-700 mr-3"
                          href={route("take-exam", questionnaire)}
                        >
                          {questionnaire.title}
                        </Link>
                      ) : (
                        <span>{questionnaire.title}</span>
                      )}
                    </td>
                    <td className="px-3 py-2">
                      {limitString(questionnaire.description, 100)}
                    </td>
                    <td className="px-3 py-2">
                      {questionnaire.updated_at_for_humans}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <Pagination class="mt-6" links={questionnaires.meta.links} />
        </div>
      </div>
    </FrontendLayout>
  );
}
