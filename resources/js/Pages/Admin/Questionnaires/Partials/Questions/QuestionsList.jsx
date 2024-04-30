import TableHeading from "@/Components/TableHeading";
import React, { useState, useEffect } from "react";
import TextInput from "@/Components/TextInput";
import { Link, router } from "@inertiajs/react";
import QuestionsCreate from "./QuestionsCreate";
import QuestionsEdit from "./QuestionsEdit";
import { useCallback, useMemo } from "react";

export default function QuestionsList({
  className = "",
  questionnaire,
  questions,
  status,
}) {
  const [sort, setSort] = useState({
    order: "asc",
    order_by: "priority",
  });

  const [search, setSearch] = useState("");

  /* Debounce */
  useEffect(() => {
    const handler = setTimeout(() => {
      setSearch(search.trim());
    }, 300);
    return () => clearTimeout(handler);
  }, [search]);

  /* Immutability Principle (questions) */
  const filtered_questions = useMemo(() => {
    const filtered = questions.filter((item) =>
      item.question.toLowerCase().includes(search.toLowerCase())
    );
    return filtered.sort((a, b) => {
      const isAscending = sort.order === "asc";
      switch (sort.order_by) {
        case "question":
          return isAscending
            ? a.question.localeCompare(b.question)
            : b.question.localeCompare(a.question);
        case "created_at":
        case "updated_at":
          return isAscending
            ? new Date(a[sort.order_by]) - new Date(b[sort.order_by])
            : new Date(b[sort.order_by]) - new Date(a[sort.order_by]);
        default:
          return isAscending
            ? a[sort.order_by] - b[sort.order_by]
            : b[sort.order_by] - a[sort.order_by];
      }
    });
  }, [questions, search, sort]);

  const onKeyPress = useCallback(
    (e) => {
      if (e.key !== "Enter") return;

      setSearch(e.target.value);
    },
    [search]
  );

  const sortChanged = useCallback(
    (name) => {
      if (name === sort.order_by) {
        setSort({ ...sort, order: sort.order === "asc" ? "desc" : "asc" });
      } else {
        setSort({ order_by: name, order: "asc" });
      }
    },
    [sort]
  );

  const destroy = useCallback((id, question) => {
    router.delete(route("admin.questions.destroy", id), {
      preserveScroll: true,
      onBefore: () =>
        confirm(
          "Are you sure you want to delete this question {" + question + "}?"
        ),
    });
  }, []);

  const tableHeaders = useMemo(() => (
    <tr className="text-nowrap">
      <TableHeading
        name="id"
        sort_field={sort.order_by}
        sort_direction={sort.order}
        sortChanged={sortChanged}
      >
        ID
      </TableHeading>
      <TableHeading
        name="question"
        sort_field={sort.order_by}
        sort_direction={sort.order}
        sortChanged={sortChanged}
      >
        Question
      </TableHeading>
      <TableHeading
        name="priority"
        sort_field={sort.order_by}
        sort_direction={sort.order}
        sortChanged={sortChanged}
      >
        Priority
      </TableHeading>
      <TableHeading
        name="created_at"
        sort_field={sort.order_by}
        sort_direction={sort.order}
        sortChanged={sortChanged}
      >
        Create Date
      </TableHeading>
      <TableHeading
        name="updated_at"
        sort_field={sort.order_by}
        sort_direction={sort.order}
        sortChanged={sortChanged}
      >
        Update Date
      </TableHeading>
      <th className="px-3 py-3 text-left">Actions</th>
    </tr>
  ));

  return (
    <section className={className}>
      <header>
        <div className="flex justify-between items-center">
          <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
            Questions
          </h2>

          <div className="flex items-center">
            <Link
              href={route("admin.questionnaires.reindex", questionnaire.id)}
              className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-3"
            >
              Re-index
            </Link>

            <QuestionsCreate
              className="max-w-full"
              questionnaire={questionnaire}
            />
          </div>
        </div>
      </header>

      <div className="overflow-auto mt-5">
        {status && (
          <div className="mb-4 font-medium text-sm text-green-600">
            {status}
          </div>
        )}
        <table className="w-full text-sm text-left rtl:text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
            {tableHeaders}
          </thead>
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
            <tr className="text-nowrap">
              <th className="px-3 py-3"></th>
              <th className="px-3 py-3">
                <TextInput
                  className="w-full"
                  autoComplete="off"
                  placeholder="Search Question"
                  onBlur={(e) => setSearch(e.target.value)}
                  // onBlur={() => handleSearch()}
                  onKeyPress={(e) => onKeyPress(e)}
                />
              </th>
              <th className="px-3 py-3"></th>
              <th className="px-3 py-3"></th>
              <th className="px-3 py-3"></th>
              <th className="px-3 py-3"></th>
            </tr>
          </thead>
          {filtered_questions.length > 0 && (
            <tbody className="divide-y divide-gray-200">
              {filtered_questions.map((question) => (
                <tr
                  className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                  key={question.id}
                >
                  <td className="px-3 py-2">{question.id}</td>
                  <td className="px-3 py-2">{question.question}</td>
                  <td className="px-3 py-2">{question.priority}</td>
                  <td className="px-3 py-2">
                    {question.created_at_for_humans}
                  </td>
                  <td className="px-3 py-2">
                    {question.updated_at_for_humans}
                  </td>
                  <td className="px-3 py-2">
                    <QuestionsEdit className="max-w-full" question={question} />
                    <button
                      onClick={() => destroy(question.id, question.question)}
                      type="button"
                      className="text-red-500 hover:text-red-700"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          )}
        </table>
      </div>
    </section>
  );
}
