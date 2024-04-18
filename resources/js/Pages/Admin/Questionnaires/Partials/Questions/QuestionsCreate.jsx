import { useRef, useState } from "react";
import DangerButton from "@/Components/DangerButton";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Modal from "@/Components/Modal";
import SecondaryButton from "@/Components/SecondaryButton";
import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/react";
import SuccessButton from "@/Components/SuccessButton";
import PrimaryButton from "@/Components/PrimaryButton";
import SelectInput from "@/Components/SelectInput";
import { useEffect } from "react";

export default function QuestionsCreate({ className = "" }) {
  const [showModal, setShowModal] = useState(false);
  const [optionData, setOptionData] = useState([]);
  const [htmlOptions, setHtmlOptions] = useState([]);

  const { data, setData, post, processing, reset, errors } = useForm({
    question: "",
    answer: "",
    choices: "",
  });

  useEffect(() => {
    console.log(optionData, htmlOptions);
  }, [optionData, htmlOptions]);

  const addNew = () => {
    setShowModal(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    console.log("submit");
  };

  const closeModal = () => {
    setShowModal(false);

    reset();
  };

  const handleOnChangeOption = (e, key) => {
    const { name, value } = e.target;
    setOptionData((prevOptionData) => ({
      ...prevOptionData,
      [key]: value,
    }));
  };

  const handleRemoveOption = (key) => {
    setOptionData((prevOptionData) => {
      // Create a new object without the deleted key
      const newOptionData = { ...prevOptionData };

      delete newOptionData[key];

      return newOptionData;
    });

    setHtmlOptions((prevHtmlOptions) => {
      // Filter out the HTML option corresponding to the deleted key
      const newHtmlOptions = prevHtmlOptions.filter(
        (option) => option.key !== key
      );
      return newHtmlOptions;
    });
  };

  const handleAddOptions = () => {
    const id = Object.keys(optionData).length + 1;
    const key = "option_" + id;

    setOptionData((prevOptionData) => ({
      ...prevOptionData,
      [key]: null,
    }));

    const newOption = (
      <div key={key} className="mt-6">
        <label
          htmlFor={key}
          className="block font-medium text-sm text-gray-700 dark:text-gray-300"
        >
          Option {id}
        </label>
        <div className="flex">
          <input
            id={key}
            name={key}
            placeholder={`Option ${id}`}
            type="text"
            className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-11/12 mr-2 border px-4 py-2"
            onChange={(e) => handleOnChangeOption(e, key)}
          />
          <button
            type="button"
            className="mt-1 inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-1/12"
            onClick={() => handleRemoveOption(key)}
          >
            Remove
          </button>
        </div>
      </div>
    );

    setHtmlOptions((prevOptions) => [...prevOptions, newOption]);
  };

  return (
    <section className={`space-y-6 ${className}`}>
      <SuccessButton onClick={addNew}>Add New</SuccessButton>

      <Modal
        show={showModal}
        onClose={closeModal}
        closeable={false}
        maxWidth="5xl"
      >
        <form onSubmit={handleSubmit} className="p-6">
          <div className="mt-6">
            <InputLabel htmlFor="question" value="Question" />

            <TextInput
              id="question"
              name="question"
              value={data.question}
              onChange={(e) => setData("question", e.target.value)}
              className="mt-1 block w-full"
              isFocused
              placeholder="Question"
            />

            <InputError message={errors.question} className="mt-2" />
          </div>

          <div className="mt-6">
            <SuccessButton type="button" onClick={handleAddOptions}>
              Add Choices
            </SuccessButton>
            <div className="mt-6">{htmlOptions.map((option) => option)}</div>
          </div>

          <div className="mt-6">
            <InputLabel htmlFor="answer" value="Answer" />

            <SelectInput
              name="answer"
              id="answer"
              className="mt-1 block w-full"
              onChange={(e) => setData("answer", e.target.value)}
            >
              <option value="">Select Answer</option>
              {Object.keys(optionData).map((key, index) => (
                <option value={index} key={key}>
                  {optionData[key]}
                </option>
              ))}
            </SelectInput>
          </div>

          <div className="border-t border-gray-300 my-6 mt-5"></div>

          <div className="mt-6 flex justify-end">
            <SecondaryButton onClick={closeModal}>Cancel</SecondaryButton>

            <PrimaryButton className="ms-3" disabled={processing}>
              Submit
            </PrimaryButton>
          </div>
        </form>
      </Modal>
    </section>
  );
}
