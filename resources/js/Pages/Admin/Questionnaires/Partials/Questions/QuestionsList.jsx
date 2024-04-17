import TableHeading from "@/Components/TableHeading";
import React, { useState, useEffect } from "react";
import TextInput from "@/Components/TextInput";
import { Link, router } from "@inertiajs/react";

export default function QuestionsList({
  className = "",
  questionnaire,
  status,
}) {
  const [sort, setSort] = useState({
    order: "asc",
    order_by: "priority",
  });

  const questions = questionnaire.questions;
  const [filtered_questions, setFilteredQuestions] = useState([]);
  const [search, setSearch] = useState("");

  useEffect(() => {
    filterList();
  }, [sort, search, questions]);

  const filterList = () => {
    const questions_copy = [...questions];
    const search_results = searchList(questions_copy);
    const sorted_results = sortList(search_results);

    setFilteredQuestions(sorted_results);
  };

  const searchList = (items) => {
    return items.filter((item) =>
      item.question.toLowerCase().includes(search.toLowerCase())
    );
  };

  const sortList = (items) => {
    return items.sort((a, b) => {
      switch (sort.order_by) {
        case "question":
          const nameA = a[sort.order_by].toUpperCase();
          const nameB = b[sort.order_by].toUpperCase();

          let comparison = 0;

          if (nameA < nameB) {
            comparison = -1;
          }
          if (nameA > nameB) {
            comparison = 1;
          }

          return sort.order === "desc" ? comparison * -1 : comparison;
        case "created_at":
        case "updated_at":
          if (sort.order === "asc") {
            return new Date(b[sort.order_by]) - new Date(a[sort.order_by]);
          } else {
            return new Date(a[sort.order_by]) - new Date(b[sort.order_by]);
          }
        default:
          if (sort.order === "asc") {
            return a[sort.order_by] - b[sort.order_by];
          } else {
            return b[sort.order_by] - a[sort.order_by];
          }
      }
    });
  };

  const onKeyPress = (e) => {
    if (e.key !== "Enter") return;

    setSearch(e.target.value);
  };

  const sortChanged = (name) => {
    if (name === sort.order_by) {
      setSort({ ...sort, order: sort.order === "asc" ? "desc" : "asc" });
    } else {
      setSort({ order_by: name, order: "asc" });
    }
  };

  const destroy = (id, question) => {
    router.delete(route("admin.questions.destroy", id), {
      preserveScroll: true,
      onBefore: () =>
        confirm(
          "Are you sure you want to delete this question {" + question + "}?"
        ),
    });
  };

  return (
    <section className={className}>
      <header>
        <div className="flex justify-between items-center">
          <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
            Questions
          </h2>

          <Link
            href={route("admin.questions.create")}
            className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
          >
            Add new
          </Link>
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
                    <Link
                      className="text-yellow-500 hover:text-yellow-700 mr-3"
                      href={route("admin.questions.edit", question.id)}
                    >
                      Edit
                    </Link>
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
