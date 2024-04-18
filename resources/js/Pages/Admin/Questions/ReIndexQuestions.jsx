import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import React, { useState, useEffect } from "react";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Dashboard({ auth, questionnaire, status }) {
  const [questions, setQuestions] = useState(questionnaire.questions);
  const { data, setData, put, processing } = useForm({});

  useEffect(() => {
    setQuestions(questionnaire.questions);
  }, [questionnaire]);

  useEffect(() => {
    prepareData();
  }, [questions]);

  const handleDragEnd = (result) => {
    if (!result.destination) return;

    const items = Array.from(questions);
    const [reorderedItem] = items.splice(result.source.index, 1);
    items.splice(result.destination.index, 0, reorderedItem);

    setQuestions(items);
  };

  const handleUpdate = () => {
    put(route("admin.questions.update.priority", questionnaire));
  };

  const prepareData = () => {
    const newData = questions.map((obj, index) => ({
      id: obj.id,
      priority: index + 1,
    }));

    setData(newData);
  };

  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Re-index Questions
          </h2>
        </div>
      }
    >
      <Head title="Admin Re-index Questions" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                  {status}
                </div>
              )}
              <div className="overflow-auto">
                <DragDropContext onDragEnd={handleDragEnd}>
                  <Droppable droppableId="rows">
                    {(provided) => (
                      <table
                        {...provided.droppableProps}
                        ref={provided.innerRef}
                        className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                      >
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                          <tr>
                            <th className="px-3 py-3 text-left">ID</th>
                            <th className="px-3 py-3 text-left">Question</th>
                            <th className="px-3 py-3 text-left">Priority</th>
                          </tr>
                        </thead>
                        <tbody>
                          {questions.map((row, index) => (
                            <Draggable
                              key={row.id.toString()}
                              draggableId={row.id.toString()}
                              index={index}
                            >
                              {(provided) => (
                                <tr
                                  ref={provided.innerRef}
                                  {...provided.draggableProps}
                                  {...provided.dragHandleProps}
                                  className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                >
                                  <td className="px-3 py-2">{row.id}</td>
                                  <td className="px-3 py-2">{row.question}</td>
                                  <td className="px-3 py-2">{row.priority}</td>
                                </tr>
                              )}
                            </Draggable>
                          ))}
                          {provided.placeholder}
                        </tbody>
                      </table>
                    )}
                  </Droppable>
                </DragDropContext>
                <div className="flex items-center justify-end mt-5 mb-5">
                  <PrimaryButton
                    className="ml-4"
                    disabled={processing}
                    onClick={handleUpdate}
                  >
                    Re-index
                  </PrimaryButton>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
